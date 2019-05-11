@extends('layouts.app')

@section('title', 'New reservation')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>
                New reservation
            </h1>
        </div>

        <form action="{{ route('reservations.create') }}" method="post">
            @csrf

            <div class="text-sm text-gray-700 mb-2">
                All fields are required unless otherwide noted.
            </div>

            <div class="md:flex my-2">
                <div class="md:w-1/4">
                    <label for="starts_at">
                        Start date & time
                    </label>
                </div>

                <div class="md:w-3/4">
                    <date-time-picker
                        id="starts_at"
                        initial-value="{{ old('starts_at') }}"
                    ></date-time-picker>

                    @error('starts_at')
                        <span class="text-xs text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="md:flex my-2">
                <div class="md:w-1/4">
                    <label for="starts_at">
                        End date & time
                    </label>
                </div>

                <div class="md:w-3/4">
                    <date-time-picker
                        id="ends_at"
                        initial-value="{{ old('ends_at') }}"
                    ></date-time-picker>

                    @error('ends_at')
                        <span class="text-xs text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="md:flex my-4">
                <div class="md:w-1/4">
                    <label for="item_selector">
                        Items
                    </label>

                    <div class="text-xs text-gray-700">
                        You may also add items after creating the reservation.
                    </div>
                </div>

                <div class="w-3/4">
                    <new-reservation-item-selector
                        url="{{ route('api.instances.index', ['all' => true]) }}"
                        :values="{{ json_encode(old('items', [])) }}"
                    ></new-reservation-item-selector>
                </div>

                @error('items')
                    <span class="text-xs text-red-700">{{ $message }}</span>
                @enderror
            </div>

            <div class="md:flex my-2">
                <div class="w-1/4">
                    <label for="approval_status">
                        Approval status
                    </label>
                </div>

                <div class="md:w-3/4">
                    <select id="approval_status" name="approval_status" class="input-select">
                        <option value="{{ \App\Models\Reservations\ReservationApprovalStatus::awaiting() }}"
                            {{ old('approval_status') == \App\Models\Reservations\ReservationApprovalStatus::awaiting() ? "selected" : "" }}>Waiting</option>
                        <option value="{{ \App\Models\Reservations\ReservationApprovalStatus::approved() }}"
                            {{ old('approval_status') == \App\Models\Reservations\ReservationApprovalStatus::approved() ? "selected" : "" }}>Approved</option>
                        <option value="{{ \App\Models\Reservations\ReservationApprovalStatus::rejected() }}"
                            {{ old('approval_status') == \App\Models\Reservations\ReservationApprovalStatus::rejected() ? "selected" : "" }}>Rejected</option>
                    </select>

                    @error('stock_type')
                        <span class="text-xs text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="md:flex my-2">
                <div class="w-1/4"></div>
                <div class="w-3/4">
                    <button class="button-white" type="submit" name="submit" value="normal">
                        Save
                    </button>

                    <button class="button-white" type="submit" name="submit" value="another">
                        Save and create another
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
