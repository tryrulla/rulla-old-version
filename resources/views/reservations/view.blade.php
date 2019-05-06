@extends('layouts.app')

@section('title', $reservation->identifier)

@section('content')
    <div class="bg-white shadow rounded-lg">
        <div class="bg-gray-400 p-4 rounded-t flex justify-between">
            <h1 class="text-xl text-black font-bold">
                {{ $reservation->identifier }}
            </h1>
        </div>

        <div>
            <reservation-page
                :data="{{ json_encode($reservation) }}"
                update-url="{{ route('api.reservations.update', $reservation) }}"
                item-url="{{ route('api.instances.index', ['all' => true]) }}"
            ></reservation-page>
        </div>
    </div>
@endsection
