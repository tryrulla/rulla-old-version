<?php

use App\Models\Items\ItemInstance;
use App\Models\Items\ItemStockBalance;
use App\Models\Items\ItemType;
use App\Models\Location;
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
        // create the real examples
        $this->call(MicrophoneSeed::class);

        /** @var Collection $locations */
        $locations = factory(Location::class, 10)->create();

        factory(ItemInstance::class, 10)->create();

        // create the fake examples
        $faker = Faker::create();
        factory(ItemType::class, 6)->create()->each(function (ItemType $type) use ($faker, $locations) {
            if ($type->stock_type->isInstance()) {
                $type->instances()->saveMany(factory(ItemInstance::class, 10)->make());
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
    }
}
