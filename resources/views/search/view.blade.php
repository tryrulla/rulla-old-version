@extends('layouts.app')

@section('title', 'Search')

@section('content')
    <div class="bg-white shadow rounded-lg">
        <div class="bg-gray-400 p-4 rounded-t flex justify-between">
            <h1 class="text-xl text-black font-bold">
                Search for <span class="font-normal">'{{ $query }}'</span>
            </h1>
        </div>

        <div class="p-4">
            <p>
                There are {{ $results->count() }} results.
            </p>

            @foreach($results->groupByType() as $type => $modelSearchResults)
                <h2 class="text-lg mt-2 mb-1">{{ $type }}</h2>

                @foreach($modelSearchResults as $result)
                    <ul class="list-disc pl-4">
                        <li><a href="{{ $result->url }}">{{ $result->title }}</a></li>
                    </ul>
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
