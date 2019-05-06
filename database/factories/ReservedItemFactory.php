<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Items\ItemInstance;
use App\Models\Reservations\ReservedItem;
use App\Models\Reservations\ReservedItemStatus;
use Faker\Generator as Faker;

$factory->define(ReservedItem::class, function (Faker $faker) {
    return [
        'status' => ReservedItemStatus::inStock(),
        'item_id' => ItemInstance::all()->random()->id,
    ];
});
