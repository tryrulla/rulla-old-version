<?php

namespace App\Http\Controllers;

use App\Models\Items\ItemStockType;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

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
        if ($request->has('all')) {
            return Location::all();
        }

        return Location::paginate(25);
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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
