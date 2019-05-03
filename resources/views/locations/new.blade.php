@extends('layouts.app')

@section('title', 'New location')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>
                New location
            </h1>
        </div>

        <form action="{{ route('locations.create') }}" method="post" class="p-4">
            @csrf

            <div class="text-sm text-gray-700 mb-2">
                All fields are required unless otherwide noted.
            </div>

            <div class="md:flex my-2">
                <div class="md:w-1/4">
                    <label for="name">
                        Name
                    </label>
                </div>

                <div class="md:w-3/4">
                    <input id="name" name="name" class="input-text" value="{{ old('name') }}" placeholder="Name">

                    @error('name')
                        <span class="text-xs text-red-700">{{ $message }}</span>
                    @enderror
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
