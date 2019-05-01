@extends('layouts.app')

@section('title', 'All locations')

@section('content')
    <location-list url="{{ $url }}"></location-list>
@endsection
