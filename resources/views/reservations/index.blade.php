@extends('layouts.app')

@section('title', 'All reservations')

@section('content')
    <reservation-list
        url="{{ $url }}"
        new-url="{{ route('reservations.create') }}"
    ></reservation-list>
@endsection
