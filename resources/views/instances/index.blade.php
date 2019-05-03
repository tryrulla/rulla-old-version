@extends('layouts.app')

@section('title', 'All items')

@section('content')
    <item-instance-list
        url="{{ $url }}"
        new-url="{{ route('instances.create') }}"
    ></item-instance-list>
@endsection
