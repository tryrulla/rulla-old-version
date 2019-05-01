<?php

use App\Models\Items\ItemInstance;
use App\Models\Items\ItemStockType;
use App\Models\Items\ItemType;
use App\Models\Location;
use Illuminate\Database\Seeder;

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

        factory(Location::class, 10)->create();

        factory(ItemInstance::class, 10)->create();

        // create the fake examples
        factory(ItemType::class, 6)->create()->each(function (ItemType $type) {
            if ($type->stock_type->isInstance()) {
                $type->instances()->saveMany(factory(ItemInstance::class, 10)->make());
            }
        });
    }
}
