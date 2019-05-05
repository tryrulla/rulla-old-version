<?php

namespace App\Http\Controllers;

use App\Models\Items\ItemInstance;
use App\Models\Reservations\Reservation;
use App\Models\Reservations\ReservationApprovalStatus;
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
     * @return Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
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
