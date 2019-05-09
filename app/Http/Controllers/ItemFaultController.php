<?php

namespace App\Http\Controllers;

use App\Models\Items\Fault\ItemFault;
use App\Models\Items\Fault\ItemFaultPriority;
use App\Models\Items\Fault\ItemFaultStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemFaultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('faults.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = array_merge(
            [
                'status' => ItemFaultStatus::open(),
                'priority' => ItemFaultPriority::medium(),
                'description' => '',
            ],
            $request->validate([
                'name' => 'required|min:3',
                'item_id' => 'required|exists:item_instances,id',
                'description' => 'nullable',
                'status' => ['nullable', Rule::in(ItemFaultStatus::getValues())],
                'priority' => ['nullable', Rule::in(ItemFaultPriority::getValues())]
            ])
        );

        $fault = ItemFault::create($attributes);

        if ($request->get('submit', 'normal') === 'another') {
            session()->flash('status-color', 'green');
            session()->flash('status', "Item fault $fault->identifier was created.");

            $request->flashOnly('item_id');

            return redirect()
                ->route('faults.create');
        }

        return redirect()->route('faults.view',  $fault);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Items\Fault\ItemFault  $fault
     * @return \Illuminate\Http\Response
     */
    public function show(ItemFault $fault)
    {
        return view('faults.view', ['fault' => $fault]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Items\Fault\ItemFault  $fault
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemFault $fault)
    {
        $fault->update($request->validate([
            'name' => 'nullable|min:3',
            'description' => 'nullable',
            'status' => ['nullable', Rule::in(ItemFaultStatus::getValues())],
            'priority' => ['nullable', Rule::in(ItemFaultPriority::getValues())]
        ]));

        return response($fault);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Items\Fault\ItemFault  $fault
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemFault $fault)
    {
        //
    }
}
