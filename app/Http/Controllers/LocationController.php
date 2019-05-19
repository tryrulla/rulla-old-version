<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class LocationController extends Controller
{
    public function jsonIndex(Request $request)
    {
        $query = Location
            ::usingSearchString($request->get('search', ''))
            ->with('parent', 'children');

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
            'name' => 'required|min:2',
            'parent_id' => 'nullable|exists:locations,id',
        ]);

        $location = Location::create($data);
        $location->loadMissing('stock.item', 'instances.type',  'parents', 'childrenTree');
        return response($location);
    }

    /**
     * Display the specified resource.
     *
     * @param Location $location
     * @return Response
     */
    public function show(Location $location)
    {
        $location->loadMissing('stock.item', 'instances.type', 'parents', 'childrenTree');
        return response($location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Location $location
     * @return Response
     */
    public function update(Request $request, Location $location)
    {
        $location->update($request->validate([
            'name' => 'nullable|min:2',
            'parent_id' => [
                'bail',
                'nullable',
                'exists:locations,id',
                function ($attribute, $value, $fail) use ($location) {
                    $another = Location::with('parents')
                        ->findOrFail($value);

                    $parent = $another->parents;
                    while ($parent) {
                        if ($parent->id === $location->id) {
                            $fail('Location tree may not generate a loop.');
                            return;
                        }

                        $parent = $parent->parents;
                    }
                }
            ],
        ]));

        $location->load('stock.item', 'instances.type',  'parents', 'childrenTree');
        return response($location);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Location $location
     * @return Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
