<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Items\ItemStockType;
use App\Models\Items\ItemType;
use Faker\Generator as Faker;

function modelName(Faker $faker) {
    $name = '';

    for ($i = 0; $i < $faker->numberBetween(1, 6); $i++) {
        $name .= $faker->boolean(65) ? $faker->randomLetter : $faker->randomDigit;
    }

    $name .= '-';

    for ($i = 0; $i < 4; $i++) {
        $name .= $faker->boolean ? $faker->randomLetter : $faker->randomDigit;
    }

    return strtoupper($name);
}

$factory->define(ItemType::class, function (Faker $faker) {
    return [
        'manufacturer' => $faker->lastName . ' ' . $faker->randomElement(['LLC', 'Ltd', 'Co.', 'GmbH', 'oy', 'AB']),
        'model' => modelName($faker),
        'stock_type' => $faker->boolean ? ItemStockType::stock() : ItemStockType::instance(),
    ];
});
