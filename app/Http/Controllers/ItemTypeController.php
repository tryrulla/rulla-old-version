<?php

namespace App\Http\Controllers;

use App\Models\Items\ItemInstance;
use App\Models\Items\ItemType;
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
