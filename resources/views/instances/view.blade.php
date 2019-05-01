@extends('layouts.app')

@section('title', $instance->identifier)

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>
                {{ $instance->identifier }}: {{ $instance->label }}
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
                                    id="label"
                                    :initial-value="{{ json_encode($instance->label) }}"
                                    :refresh="true"
                                ></editable-text-field>
                            </td>
                        </tr>

                        <tr>
                            <th>Type</th>
                            <td>
                                @if($instance->type)
                                        <a href="{{ $instance->type->viewUrl }}">
                                            [{{ $instance->type->identifier }}] {{ $instance->type->name }}
                                        </a>
                                @else
                                    &ndash;
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="md:w-1/2"></div>
            </div>
        </div>
    </div>
@endsection
