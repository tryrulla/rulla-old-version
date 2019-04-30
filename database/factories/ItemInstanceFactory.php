<?php

/* @var $factory Factory */

use App\Models\Items\ItemInstance;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ItemInstance::class, function (Faker $faker) {
    return [
        'label' => '',
    ];
});
