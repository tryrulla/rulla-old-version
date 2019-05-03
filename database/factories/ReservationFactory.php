<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Reservations\Reservation;
use App\Models\Reservations\ReservationStatus;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Reservation::class, function (Faker $faker) {
    return [
        'status' => ReservationStatus::planned(),
        'author_id' => User::all()->random()->id,
        'starts_at' => now()->addMinutes($faker->numberBetween(5, 180)),
        'ends_at' => now()->addHours(2)->addMinutes($faker->numberBetween(5, 180)),
    ];
});
