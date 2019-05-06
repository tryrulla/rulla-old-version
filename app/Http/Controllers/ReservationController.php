<?php

namespace App\Http\Controllers;

use App\Models\Items\ItemInstance;
use App\Models\Reservations\Reservation;
use App\Models\Reservations\ReservationApprovalStatus;
use App\Models\Reservations\ReservationStatus;
use App\Models\Reservations\ReservedItem;
use App\Models\Reservations\ReservedItemStatus;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $url = route('api.reservations.index');
        return view('reservations.index', compact('url'));
    }

    public function jsonIndex(Request $request)
    {
        $query = QueryBuilder::for(Reservation::class)
            ->allowedFilters([
                Filter::exact('id'),
            ])
            ->with('author');

        return $request->has('all')
            ? $query->get()
            : $query->paginate(25);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('reservations.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function store(Request $request)
    {
        $attributes = array_merge(
            [
                'started' => false,
                'cancelled' => false,
                'author_id' => $request->user()->id,
                'approval_status' => ReservationApprovalStatus::awaiting(),
            ],
            $request->validate([
                'starts_at' => 'required|date',
                'ends_at' => 'required|date|after:starts_at',
                'approval_status' => ['nullable', Rule::in(ReservationApprovalStatus::getValues())],
            ])
        );

        $attributes['starts_at'] = Carbon::make($attributes['starts_at'])->tz('UTC');
        $attributes['ends_at'] = Carbon::make($attributes['ends_at'])->tz('UTC');

        DB::beginTransaction();

        try {
            $reservation = Reservation::create($attributes);
        } catch(Exception $e) {
            DB::rollback();
            throw $e;
        }

        try {
            collect($request->get('items', []))
                ->map(function ($string) {
                    return intval($string);
                })
                ->map(function ($id) {
                    return ItemInstance::find($id);
                })
                ->each(function ($item) use ($reservation) {
                    ReservedItem::create([
                        'reservation_id' => $reservation->id,
                        'item_id' => $item->id,
                        'status' => ReservedItemStatus::inStock(),
                    ]);
                });
        } catch(Exception $e) {
            DB::rollback();
            throw $e;
        }

        DB::commit();

        if ($request->get('submit', 'normal') === 'another') {
            session()->flash('status-color', 'green');
            session()->flash('status', "Reservation $reservation->identifier was created.");

            return redirect()
                ->route('reservations.create');
        }

        return redirect()->route('reservations.view', $reservation);
    }

    /**
     * Display the specified resource.
     *
     * @param Reservation $reservation
     * @return Response
     */
    public function show(Reservation $reservation)
    {
        $reservation->loadMissing('author', 'items.item.type', 'items.item.location');
        return view('reservations.view', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Reservation $reservation
     * @return Reservation
     * @throws Exception
     */
    public function update(Request $request, Reservation $reservation)
    {
        /** @var ReservationStatus $status */
        $status = $reservation->status;

        if ($request->has('cancelled')) {
            if (!$status->isAwaitingApproval() && !$status->isCancelled() && !$status->isPlanned()) {
                return abort(400, 'Invalid state');
            }

            $reservation->update($request->validate([
                'cancelled' => 'required|boolean',
            ]));
        }

        if ($request->has('add-items')) {
            if (!$status->isAwaitingApproval() && !$status->isPlanned()) {
                return abort(400, 'Invalid state');
            }

            DB::beginTransaction();

            try {
                collect($request->get('add-items', []))
                    ->map(function ($string) {
                        return intval($string);
                    })
                    ->map(function ($id) {
                        return ItemInstance::find($id);
                    })
                    ->filter(function ($item) use($reservation) {
                        return $reservation->items->filter(function ($reservedItem) use ($item) {
                            return $reservedItem->id === $item->id;
                        })->count() === 0;
                    })
                    ->each(function ($item) use ($reservation) {
                        ReservedItem::create([
                            'reservation_id' => $reservation->id,
                            'item_id' => $item->id,
                            'status' => ReservedItemStatus::inStock(),
                        ]);
                    });
            } catch(Exception $e) {
                DB::rollback();
                throw $e;
            }

            DB::commit();
        }

        if ($request->has('read-out')) {
            if (!$status->isPlanned() && !$status->isOut() && !$status->isOverdue()) {
                return abort(400, 'Invalid state');
            }

            $amount = $reservation->items()
                ->whereIn('item_id', $request->get('read-out', []))
                ->where('status', ReservedItemStatus::inStock())
                ->update([
                    'status' => ReservedItemStatus::out(),
                ]);

            if ($amount > 0 && !$reservation->started) {
                $reservation->started = true;
                $reservation->save();
            }
        }

        if ($request->has('return')) {
            if (!$status->isPlanned() && !$status->isOut() && !$status->isOverdue()) {
                return abort(400, 'Invalid state');
            }

            $amount = $reservation->items()
                ->whereIn('item_id', $request->get('return', []))
                ->where('status', ReservedItemStatus::out())
                ->update([
                    'status' => ReservedItemStatus::returned(),
                ]);

            if ($amount > 0 && !$reservation->started) {
                $reservation->started = true;
                $reservation->save();
            }
        }

        if ($request->has('approval_status')) {
            $reservation->update($request->validate([
                'approval_status' => ['required', Rule::in(ReservationApprovalStatus::getValues())],
            ]));
        }

        $reservation->load('author', 'items.item.type', 'items.item.location');
        return response()->json(['data' => $reservation, 'oldStatus' => $status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
