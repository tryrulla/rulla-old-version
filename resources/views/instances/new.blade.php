@extends('layouts.app')

@section('title', 'New instance')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>
                New instance
            </h1>
        </div>

        <form action="{{ route('instances.create') }}" method="post" class="p-4">
            @csrf

            <div class="text-sm text-gray-700 mb-2">
                All fields are required unless otherwide noted.
            </div>

            <div class="md:flex my-2">
                <div class="md:w-1/4">
                    <label for="label">
                        Label <span class="text-gray-700 text-xs">(optional)</span>
                    </label>
                </div>

                <div class="md:w-3/4">
                    <input id="label" name="label" class="input-text" value="{{ old('label') }}" placeholder="Label">

                    @error('label')
                        <span class="text-xs text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="md:flex my-2">
                <div class="md:w-1/4">
                    <label for="type_id">
                        Type <span class="text-gray-700 text-xs">(optional)</span>
                    </label>
                </div>

                <div class="w-3/4">
                    <hidden-input-search-selector
                        url="{{ route('api.types.index', ['all' => '1', 'filter' => ['stock_type' => 'instance']]) }}"
                        name="type_id"
                    ></hidden-input-search-selector>
                </div>
            </div>

            <div class="md:flex my-2">
                <div class="md:w-1/4">
                    <label for="location_id">
                        Location <span class="text-gray-700 text-xs">(optional)</span>
                    </label>
                </div>

                <div class="w-3/4">
                    <hidden-input-search-selector
                        url="{{ route('api.locations.index', ['all' => '1']) }}"
                        name="location_id"
                    ></hidden-input-search-selector>
                </div>
            </div>

            <div class="md:flex my-2">
                <div class="w-1/4"></div>
                <div class="w-3/4">
                    <button class="button-white" type="submit" name="submit" value="normal">
                        Save
                    </button>

                    <button class="button-white" type="submit" name="submit" value="another">
                        Save and create another
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
