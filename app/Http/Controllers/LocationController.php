<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $url = route('api.locations.index');
        return view('locations.index', compact('url'));
    }

    public function jsonIndex(Request $request)
    {
        $query = QueryBuilder::for(Location::class)
            ->allowedFilters([
                Filter::exact('id'),
                'name',
            ])
            ->with('stock');

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
        return view('locations.new');
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
        ]);

        $location = Location::create($data);

        if ($request->get('submit', 'normal') === 'another') {
            session()->flash('status-color', 'green');
            session()->flash('status', "Location $location->identifier was created.");

            return redirect()
                ->route('locations.create');
        }

        return redirect()->route('locations.view', $location);
    }

    /**
     * Display the specified resource.
     *
     * @param Location $location
     * @return Response
     */
    public function show(Location $location)
    {
        return view('locations.view', compact('location'));
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
        ]));

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
