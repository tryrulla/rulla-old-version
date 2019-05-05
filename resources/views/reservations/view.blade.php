@extends('layouts.app')

@section('title', $reservation->identifier)

@section('content')
    <div class="bg-white shadow rounded-lg">
        <div class="bg-gray-400 p-4 rounded-t flex justify-between">
            <h1 class="text-xl text-black font-bold">
                {{ $reservation->identifier }}
            </h1>
        </div>

        <div>
            <div class="md:flex">
                <div class="md:w-1/2 p-4">
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

                    <table class="table mt-4">
                        <tr class="header">
                            <th colspan="2">
                                Author
                            </th>
                        </tr>

                        <tr>
                            <th class="w-1/4">
                                Identifier
                            </th>

                            <td class="w-3/4">
                                {{ $reservation->author->identifier }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Name
                            </th>

                            <td>
                                {{ $reservation->author->name }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Username
                            </th>

                            <td>
                                {{ $reservation->author->username }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                E-mail
                            </th>

                            <td>
                                {{ $reservation->author->email }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="md:w-1/2 p-4">
                    <reservation-items
                        :item-data="{{ json_encode($reservation->items) }}"
                        update-url="{{ route('api.reservations.update', $reservation) }}"
                    ></reservation-items>
                </div>
            </div>
        </div>
    </div>
@endsection
