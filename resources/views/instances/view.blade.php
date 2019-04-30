@extends('layouts.app')

@section('title', $instance->identifier)

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>
                {{ $instance->identifier }}: {{ $instance->label }}
            </h1>

            <div class="text-xs">
                <a href="{{ route('instances.edit', $instance) }}" class="text-blue-800 underline">
                    edit
                </a>
            </div>
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
                            <th>Label</th>
                            <td>{{ $instance->label }}</td>
                        </tr>

                        <tr>
                            <th>Type</th>
                            <td>
                                <a href="{{ $instance->type->viewUrl }}">
                                    [{{ $instance->type->identifier }}] {{ $instance->type->name }}
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="md:w-1/2"></div>
            </div>
        </div>
    </div>
@endsection
