@extends('layouts.app')

@section('title', $reservation->identifier)

@section('content')
    <div>
        <div class="card-header">
            <h1>
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
