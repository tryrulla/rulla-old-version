@extends('layouts.app')

@section('title', 'All item types')

@section('content')
    <item-type-list
        url="{{ $url }}"
        new-url="{{ route('types.create') }}"
    ></item-type-list>
@endsection
