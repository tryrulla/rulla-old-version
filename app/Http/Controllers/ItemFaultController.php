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
        return response($fault);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Items\Fault\ItemFault  $fault
     * @return \Illuminate\Http\Response
     */
    public function show(ItemFault $fault)
    {
        return response($fault);
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

    public function comment(Request $request, ItemFault $fault) {
        $request->validate(['comment' => 'required|min:2']);
        $fault->comment($request->get('comment'));
        return back();
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
