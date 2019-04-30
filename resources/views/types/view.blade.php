@extends('layouts.app')

@section('title', $type->identifier)

@section('content')
    <div class="bg-white shadow rounded-lg">
        <div class="bg-gray-400 p-4 rounded-t flex justify-between">
            <h1 class="text-xl text-black font-bold">
                {{ $type->identifier }}: {{ $type->manufacturer }} {{ $type->model }}
            </h1>

            <div class="text-xs">
                <a href="{{ route('instances.edit', $type) }}" class="text-blue-800 underline">
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
                                {{ $type->manufacturer }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Model
                            </th>

                            <td>
                                {{ $type->model }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Stock type
                            </th>

                            <td>
                                {{ ucfirst($type->stock_type) }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="md:w-1/2"></div>
            </div>
        </div>
    </div>
@endsection
