@extends('layouts.app')

@section('title', $location->identifier)

@section('content')
    <div class="bg-white shadow rounded-lg">
        <div class="bg-gray-400 p-4 rounded-t flex justify-between">
            <h1 class="text-xl text-black font-bold">
                {{ $location->identifier }}: {{ $location->name }}
            </h1>
        </div>

        <div class="p-4">
            <div class="md:flex">
                <div class="md:w-1/2">
                    <table class="table">
                        <tr>
                            <th class="w-1/4">
                                Row type
                            </th>

                            <td class="w-3/4">
                                Location
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Identifier
                            </th>

                            <td>
                                {{ $location->identifier }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Name
                            </th>

                            <td>
                                <editable-text-field
                                    url="{{ route('api.locations.update', $location) }}"
                                    name="Name"
                                    id="name"
                                    :initial-value="{{ json_encode($location->name) }}"
                                    :refresh="true"
                                ></editable-text-field>
                            </td>
                        </tr>
                    </table>

                    <location-item-list
                        instance-url="{{ route('api.instances.index', ['all' => '1', 'filter' => ['location_id' => $location->id]]) }}"
                        stock-url="{{ route('api.types.index', ['all' => '1', 'filter' => ['has_stock_in' => $location->id]]) }}"
                        location-id="{{ $location->id }}"
                    ></location-item-list>
                </div>

                <div class="md:w-1/2"></div>
            </div>
        </div>
    </div>
@endsection
