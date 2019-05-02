<?php

namespace App\Http\Controllers;

use App\Models\Items\ItemInstance;
use App\Models\Items\ItemStockBalance;
use App\Models\Items\ItemStockType;
use App\Models\Items\ItemType;
use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $url = route('api.types.index');
        return view('types.index', compact('url'));
    }

    public function jsonIndex(Request $request)
    {
        if ($request->has('all')) {
            return ItemType::all();
        }

        return ItemType::paginate(25);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('types.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'manufacturer' => 'required|min:2',
            'model' => 'required|min:2',
            'stock_type' => ['required', Rule::in(ItemStockType::getValues())],
        ]);

        $type = ItemType::create($data);

        if ($request->get('submit', 'normal') === 'another') {
            session()->flash('status-color', 'green');
            session()->flash('status', "Item type $type->identifier was created.");

            $request->flashOnly('stock_type');

            return redirect()
                ->route('types.create');
        }

        return redirect()->route('types.view',  $type);
    }

    /**
     * Display the specified resource.
     *
     * @param ItemType $type
     * @return Response
     */
    public function show(ItemType $type)
    {
        return view('types.view', compact('type'));
    }

    public function suggestLocations(ItemType $type)
    {
        $locations = Location::whereHas('stock', function (Builder $builder) use ($type) {
            return $builder->where('type_id', '=', $type->id);
        }, '<', '1')->get();

        return $locations;
    }

    public function updateStock(Request $request, ItemType $type)
    {
        if (! $type->stock_type->isStock()) {
            return response()->json(['error' => 'Not stock'], 400);
        }

        $locationId = $request->get('location');
        $location = Location::find($locationId);

        $amount = $request->get('amount');

        $updatedStock = ItemStockBalance::updateOrCreate(
            ['type_id' => $type->id, 'location_id' => $location->id],
            ['amount' => $amount]
        );

        $stock = ItemStockBalance::with('location')
            ->find($updatedStock->id);

        return response()->json($stock, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ItemType $type
     * @return Response
     */
    public function update(Request $request, ItemType $type)
    {
        $type->update($request->validate([
            'manufacturer' => 'nullable|min:2',
            'model' => 'nullable|min:2',
            'stock_type' => ['nullable', Rule::in(ItemStockType::getValues())],
        ]));

        return response($type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ItemType $type
     * @return Response
     */
    public function destroy(ItemType $type)
    {
        //
    }
}
