@extends('layouts.app')

@section('title', $fault->identifier)

@section('content')
    <div>
        <div class="card-header">
            <div>
                <a href="{{ route('instances.view', $fault->item) }}" class="hover:underline">
                    {{ $fault->item->label ? '[' . $fault->item->identifier . '] ' : $fault->item->identifier }}{{ $fault->item->label }}</a>

                /

                <b>{{ $fault->identifier }}</b>
            </div>

            <h1 class="text-xl text-black font-bold">
                {{ $fault->name }}
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
                                Item Fault
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Identifier
                            </th>

                            <td>
                                {{ $fault->identifier }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Name
                            </th>

                            <td>
                                <editable-text-field
                                    url="{{ route('api.faults.update', $fault) }}"
                                    name="Name"
                                    id="name"
                                    :initial-value="{{ json_encode($fault->name) }}"
                                    :refresh="true"
                                ></editable-text-field>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="md:w-1/2">
                    <table class="table columned">
                        <tr>
                            <th class="w-1/4">Status</th>
                            <td>
                                <item-fault-status status="{{ $fault->status }}"></item-fault-status>
                            </td>
                        </tr>

                        <tr>
                            <th>Priority</th>
                            <td>
                                <item-fault-priority priority="{{ $fault->priority }}"></item-fault-priority>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </details>

        <details open>
            <summary>Description</summary>

            <div class="whitespace-pre-line">{{ $fault->description }}</div>
        </details>
    </div>
@endsection
