@extends('layouts.app')

@section('title', 'All items')

@section('content')
    <item-instance-list url="{{ $url }}"></item-instance-list>
@endsection
