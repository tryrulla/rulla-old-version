<?php

use App\Models\Items\ItemInstance;
use App\Models\Items\ItemStockBalance;
use App\Models\Items\ItemType;
use App\Models\Location;
use App\Models\Reservations\Reservation;
use App\Models\Reservations\ReservedItem;
use App\Models\Reservations\ReservedItemStatus;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Rulla Admin',
            'username' => 'admin',
            'email' => 'rulla-admin@tassu.me',
        ]);

        factory(User::class, 24)->create();

        // create the real examples
        $this->call(MicrophoneSeed::class);

        /** @var Collection $locations */
        $locations = factory(Location::class, 25)->create();

        factory(ItemInstance::class, 15)->create();

        // create the fake examples
        $faker = Faker::create();
        factory(ItemType::class, 26)->create()->each(function (ItemType $type) use ($faker, $locations) {
            if ($type->stock_type->isInstance()) {
                $type->instances()->saveMany(
                    factory(ItemInstance::class, 10)->make()->map(function ($instance) use ($faker) {
                        if ($faker->boolean(35)) {
                            $instance->location_id = Location::all()->random()->id;
                        }

                        return $instance;
                    })
                );
            } else if ($type->stock_type->isStock()) {
                $locations->filter(function () use ($faker) {
                    return $faker->boolean(65);
                })->map(function ($location) use ($type, $faker) {
                    /** @var Location $location */
                    ItemStockBalance::create([
                        'amount' => $faker->numberBetween(5, 25),
                        'type_id' => $type->id,
                        'location_id' => $location->id,
                    ]);
                });
            }
        });

        factory(Reservation::class, 15)->create();

        $reservation = Reservation::first();
        for ($i = 1; $i < 14; $i++) {
            ReservedItem::create([
                'item_id' => $i,
                'reservation_id' => $reservation->id,
                'status' => ReservedItemStatus::inStock(),
            ]);
        }
    }
}
