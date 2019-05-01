@extends('layouts.app')

@section('title', 'New item type')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>
                New item type
            </h1>
        </div>

        <form action="{{ route('types.create') }}" method="post" class="p-4">
            @csrf

            <div class="text-sm text-gray-700 mb-2">
                All fields are required unless otherwide noted.
            </div>

            <div class="md:flex my-2">
                <div class="md:w-1/4">
                    <label for="manufacturer">
                        Manufacturer
                    </label>
                </div>

                <div class="md:w-3/4">
                    <input id="manufacturer" name="manufacturer" class="input-text" value="{{ old('manufacturer') }}" placeholder="Manufacturer">

                    @error('manufacturer')
                        <span class="text-xs text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="md:flex my-2">
                <div class="md:w-1/4">
                    <label for="model">
                        Model
                    </label>
                </div>

                <div class="md:w-3/4">
                    <input id="model" name="model" class="input-text" value="{{ old('model') }}" placeholder="Model">

                    @error('model')
                        <span class="text-xs text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="md:flex my-2">
                <div class="md:w-1/4">
                    <label for="stock_type">
                        Stock type

                        <i class="fas fa-info-circle text-gray-600 text-xs"
                           v-tooltip="'Specifies how this item is stored.<br/><br/>&ndash; Stock: amount of items per location<br/>&ndash; Instance: every single item is stored'"
                        ></i>
                    </label>
                </div>

                <div class="md:w-3/4">
                    <select id="stock_type" name="stock_type" class="input-select">
                        <option value="{{ \App\Models\Items\ItemStockType::stock() }}"
                            {{ old('stock_type') == \App\Models\Items\ItemStockType::stock() ? "selected" : "" }}>Stock</option>
                        <option value="{{ \App\Models\Items\ItemStockType::instance() }}"
                            {{ old('stock_type') == \App\Models\Items\ItemStockType::instance() ? "selected" : "" }}>Instance</option>
                    </select>

                    @error('stock_type')
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
