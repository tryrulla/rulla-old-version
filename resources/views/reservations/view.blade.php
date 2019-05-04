@extends('layouts.app')

@section('title', $reservation->identifier)

@section('content')
    <div class="bg-white shadow rounded-lg">
        <div class="bg-gray-400 p-4 rounded-t flex justify-between">
            <h1 class="text-xl text-black font-bold">
                {{ $reservation->identifier }}
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
                                Reservation
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Identifier
                            </th>

                            <td>
                                {{ $reservation->identifier }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Status
                            </th>

                            <td>
                                <reservation-status
                                    status="{{ $reservation->status }}"
                                ></reservation-status>
                            </td>
                        </tr>

                        <tr class="mt-2">
                            <th>
                                Start date
                            </th>

                            <td>
                                <formatted-date date="{{ $reservation->starts_at }}"></formatted-date>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                End date
                            </th>

                            <td>
                                <formatted-date date="{{ $reservation->ends_at }}"></formatted-date>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Duration
                            </th>

                            <td>
                                {{ $reservation->starts_at->diffForHumans($reservation->ends_at, ['syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]) }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="md:w-1/2"></div>
            </div>
        </div>
    </div>
@endsection
