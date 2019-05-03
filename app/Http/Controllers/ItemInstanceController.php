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
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $url = route('api.instances.index');
        return view('instances.index', compact('url'));
    }

    public function jsonIndex(Request $request)
    {
        $query = QueryBuilder::for(ItemInstance::class)
            ->allowedFilters(Filter::exact('id'), 'label', Filter::exact('location_id'), Filter::exact('type_id'))
            ->with('type', 'location');

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
        return view('instances.new');
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

        if ($request->get('submit', 'normal') === 'another') {
            session()->flash('status-color', 'green');
            session()->flash('status', "Item instance $instance->identifier was created.");

            $request->flashOnly('location_id');

            return redirect()
                ->route('instances.create');
        }

        return redirect()->route('instances.view',  $instance);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Items\ItemInstance  $instance
     * @return Response
     */
    public function show(ItemInstance $instance)
    {
        return view('instances.view', compact('instance'));
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
