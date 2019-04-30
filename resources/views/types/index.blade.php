@extends('layouts.app')

@section('title', 'All item types')

@section('content')
    <item-type-list url="{{ $url }}"></item-type-list>
@endsection
