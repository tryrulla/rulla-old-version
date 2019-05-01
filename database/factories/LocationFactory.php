<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'name' => 'Room ' . strtoupper($faker->randomLetter . $faker->randomDigit . $faker->randomDigit . $faker->randomDigit),
    ];
});
