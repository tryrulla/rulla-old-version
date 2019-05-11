@extends('layouts.app')

@section('title', $instance->identifier)

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <a href="{{ route('instances.index') }}">
                    Item Instance
                </a>

                {!! $instance->label ? '/ <b>' . $instance->identifier . '</b>' : '' !!}
            </div>

            <h1>
                {{ $instance->label ? $instance->label : $instance->identifier }}
            </h1>
        </div>

        <div class="mb-4">
            <a href="{{ route('faults.create', ['item_id' => $instance->id]) }}" class="button-gray">
                Add fault
            </a>
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
                                Item Instance
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Identifier
                            </th>

                            <td>
                                {{ $instance->identifier }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Label
                                <i class="fas fa-info-circle text-gray-600 text-xs"
                                   v-tooltip="'Short name/description. Will be printed on any tags.'"
                                ></i>
                            </th>

                            <td>
                                <editable-text-field
                                    url="{{ route('api.instances.update', $instance) }}"
                                    name="Label"
                                    id="label"
                                    :initial-value="{{ json_encode($instance->label) }}"
                                    :refresh="true"
                                ></editable-text-field>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="md:w-1/2">
                    <table class="table columned">
                        <tr>
                            <th class="w-1/4">Type</th>
                            <td>
                                <editable-select
                                    url="{{ route('api.instances.update', $instance) }}"
                                    data-url="{{ route('api.types.index', ['all' => '1', 'filter' => ['stock_type' => 'instance']]) }}"
                                    id="type_id"
                                    name="Item type"
                                    :label="type => type ? `[${type.identifier}] ${type.name}` : '–'"
                                    :get-value="type => type ? type.id : null"
                                    :initial-value="{{ $instance->type ? $instance->type->id : 'null' }}"
                                    :refresh="true"
                                ></editable-select>
                            </td>
                        </tr>

                        <tr>
                            <th>Location</th>
                            <td>
                                <editable-select
                                    url="{{ route('api.instances.update', $instance) }}"
                                    data-url="{{ route('api.locations.index', ['all' => '1']) }}"
                                    id="location_id"
                                    name="Location"
                                    :label="location => location ? `[${location.identifier}] ${location.name}` : '–'"
                                    :get-value="location => location ? location.id : null"
                                    :initial-value="{{ $instance->location ? $instance->location->id : 'null' }}"
                                    :refresh="true"
                                ></editable-select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </details>

        <details open>
            <summary>Faults</summary>

            <item-instance-faults
                :data="{{ json_encode($instance->faults) }}"
            ></item-instance-faults>
        </details>
    </div>
@endsection
