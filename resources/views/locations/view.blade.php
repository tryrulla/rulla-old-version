@extends('layouts.app')

@section('title', $location->identifier)

@section('content')
    <div>
        <div class="card-header">
            <div>
                <a href="{{ route('locations.index') }}">
                    Location
                </a>

                /

                <b>{{ $location->identifier }}</b>
            </div>

            <h1>
                {{ $location->name }}
            </h1>
        </div>

        <details open>
            <summary>Basic details</summary>

            <div class="md:flex">
                <div class="md:w-1/2">
                    <table class="table columned">
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
                </div>

                <div class="md:w-1/2"></div>
            </div>
        </details>

        <location-item-list
            instance-url="{{ route('api.instances.index', ['all' => '1', 'filter' => ['location_id' => $location->id]]) }}"
            stock-url="{{ route('api.types.index', ['all' => '1', 'filter' => ['has_stock_in' => $location->id]]) }}"
            :location-id="{{ $location->id }}"
        ></location-item-list>
    </div>
@endsection
