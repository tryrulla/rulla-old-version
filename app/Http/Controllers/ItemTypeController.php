<?php

namespace App\Http\Controllers;

use App\Models\Items\ItemInstance;
use App\Models\Items\ItemStockBalance;
use App\Models\Items\ItemType;
use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = route('api.types.index');
        return view('types.index', compact('url'));
    }

    public function jsonIndex()
    {
        return ItemType::paginate();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Items\ItemType  $type
     * @return \Illuminate\Http\Response
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Items\ItemType  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemType $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Items\ItemType  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemType $type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Items\ItemType  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemType $type)
    {
        //
    }
}
