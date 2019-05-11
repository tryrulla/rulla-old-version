@extends('layouts.app')

@section('title', 'New fault')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>
                New fault
            </h1>
        </div>

        <form action="{{ route('faults.create') }}" method="post">
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
                <div class="md:w-1/4">
                    <label for="description">
                        Description
                    </label>
                </div>

                <div class="md:w-3/4">
                    <textarea name="description" id="description" class="input-text">{{ old('name') }}</textarea>

                    @error('description')
                    <span class="text-xs text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="md:flex my-2">
                <div class="md:w-1/4">
                    <label for="item_id">
                        Item
                    </label>
                </div>

                <div class="w-3/4">
                    <hidden-input-search-selector
                        url="{{ route('api.instances.index', ['all' => '1']) }}"
                        name="item_id"
                        :value="{{ old('item_id', json_encode(intval(Request::get('item_id')))) }}"
                        :label="it => `[${it.identifier}] ${it.label}`"
                    ></hidden-input-search-selector>

                    @error('item_id')
                    <span class="text-xs text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="md:flex my-2">
                <div class="md:w-1/4">
                    <label for="priority">
                        Priority
                    </label>
                </div>

                <div class="md:w-3/4">
                    <select id="priority" name="priority" class="input-select">
                        <option value="lowest"
                            {{ old('priority') == "lowest" ? "selected" : "" }}>Lowest</option>
                        <option value="low"
                            {{ old('priority') == "low" ? "selected" : "" }}>Low</option>
                        <option value="medium"
                            {{ old('priority', 'medium') == "medium" ? "selected" : "" }}>Medium</option>
                        <option value="high"
                            {{ old('priority') == "high" ? "selected" : "" }}>High</option>
                        <option value="highest"
                            {{ old('priority') == "highest" ? "selected" : "" }}>Highest</option>
                    </select>

                    @error('priority')
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
