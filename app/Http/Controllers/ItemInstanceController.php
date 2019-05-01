<?php

namespace App\Http\Controllers;

use App\Models\Items\ItemInstance;
use App\Models\Items\ItemStockType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

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

    public function jsonIndex()
    {
        return ItemInstance::with('type')
            ->paginate(25);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
            'label' => 'nullable',
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
