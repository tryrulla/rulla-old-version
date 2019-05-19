<?php

namespace App\Http\Controllers;

use App\Models\Items\ItemStockBalance;
use App\Models\Items\ItemStockType;
use App\Models\Items\ItemType;
use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class ItemTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = ItemType
            ::usingSearchString($request->get('search', ''))
            ->with('stockBalances');

        return $request->has('all')
            ? $query->get()
            : $query->paginate(25);
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

        $type->loadMissing('stockBalances.location', 'instances.location');
        return response($type);
    }

    /**
     * Display the specified resource.
     *
     * @param ItemType $type
     * @return Response
     */
    public function show(ItemType $type)
    {
        $type->loadMissing('stockBalances.location', 'instances.location');
        return response($type);
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

        ItemStockBalance::updateOrCreate(
            ['type_id' => $type->id, 'location_id' => $location->id],
            ['amount' => $amount]
        );

        $type->load('stockBalances.location', 'instances.location');
        return response()->json($type, 200);
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
