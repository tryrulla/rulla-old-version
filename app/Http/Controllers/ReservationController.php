<?php

namespace App\Http\Controllers;

use App\Models\Reservations\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $url = route('api.reservations.index');
        return view('reservations.index', compact('url'));
    }

    public function jsonIndex(Request $request)
    {
        $query = QueryBuilder::for(Reservation::class)
            ->allowedFilters([
                Filter::exact('id'),
            ])
            ->with('author');

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
     * @param Reservation $reservation
     * @return Response
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reservation $reservation
     * @return Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Reservation $reservation
     * @return Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
