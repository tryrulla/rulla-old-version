@extends('layouts.app')

@section('title', 'All locations')

@section('content')
    <location-list
        url="{{ $url }}"
        new-url="{{ route('locations.create') }}"
    ></location-list>
@endsection
