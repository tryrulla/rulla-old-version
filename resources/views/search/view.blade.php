@extends('layouts.app')

@section('title', 'Search')

@section('content')
    <div>
        <div class="card-header">
            <div>
                Found {{ $results->count() }} result(s) for
            </div>
            <h1>
                {{ $query }}
            </h1>
        </div>

        <div>
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
