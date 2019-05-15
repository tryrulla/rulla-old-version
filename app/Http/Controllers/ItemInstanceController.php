<?php

namespace App\Http\Controllers;

use App\Models\Items\ItemInstance;
use App\Models\Items\ItemStockType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class ItemInstanceController extends Controller
{
    public function index(Request $request)
    {
        $query = QueryBuilder::for(ItemInstance::class)
            ->allowedFilters(Filter::exact('id'), 'label', Filter::exact('location_id'), Filter::exact('type_id'))
            ->with('type', 'location', 'faults');

        return $request->has('all')
            ? $query->get()
            : $query->paginate(25);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => 'nullable|min:2',
            'type_id' => 'nullable|exists:item_types,id',
            'location_id' => 'nullable|exists:locations,id',
        ]);

        $instance = ItemInstance::create($data);

        $instance->loadMissing('type', 'location', 'faults');
        return response($instance);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Items\ItemInstance  $instance
     * @return Response
     */
    public function show(ItemInstance $instance)
    {
        $instance->loadMissing('type', 'location', 'faults');
        return response($instance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Items\ItemInstance  $instance
     * @return Response
     */
    public function update(Request $request, ItemInstance $instance)
    {
        $instance->update($request->validate([
            'label' => 'nullable|min:2',
            'type_id' => 'nullable|exists:item_types,id',
            'location_id' => 'nullable|exists:locations,id',
        ]));

        $instance->load('type', 'location', 'faults');
        return response($instance);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Items\ItemInstance  $instance
     * @return Response
     */
    public function destroy(ItemInstance $instance)
    {
        //
    }
}
