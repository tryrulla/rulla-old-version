@extends('layouts.app')

@section('title', $type->identifier)

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>
                {{ $type->identifier }}: {{ $type->manufacturer }} {{ $type->model }}
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
                                Item Type
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Identifier
                            </th>

                            <td>
                                {{ $type->identifier }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Manufacturer
                            </th>

                            <td>
                                <editable-text-field
                                    url="{{ route('api.types.update', $type) }}"
                                    id="manufacturer"
                                    name="Manufacturer"
                                    :initial-value="{{ json_encode($type->manufacturer) }}"
                                    :refresh="true"
                                ></editable-text-field>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Model
                            </th>

                            <td>
                                <editable-text-field
                                    url="{{ route('api.types.update', $type) }}"
                                    id="model"
                                    name="Model"
                                    :initial-value="{{ json_encode($type->model) }}"
                                    :refresh="true"
                                ></editable-text-field>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Stock type
                                <i class="fas fa-info-circle text-gray-600 text-xs"
                                   v-tooltip="'Specifies how this item is stored.<br/><br/>&ndash; Stock: amount of items per location<br/>&ndash; Instance: every single item is stored'"
                                ></i>
                            </th>

                            <td>
                                <editable-select
                                    url="{{ route('api.types.update', $type) }}"
                                    id="stock_type"
                                    name="Stock type"
                                    initial-value="{{ $type->stock_type }}"
                                    :options="[{label: 'Instance', value: 'instance'}, {label: 'Stock', value: 'stock'}]"
                                    :refresh="true"
                                ></editable-select>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="md:w-1/2">
                    @if($type->stock_type->isStock())
                        <item-stock-balance
                            :initial-data="{{ $type->stockBalances()->with('location')->get() }}"
                            save-url="{{ route('api.types.updateStock', $type) }}"
                            suggestion-url="{{ route('api.types.suggestLocations', $type) }}"
                        ></item-stock-balance>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
