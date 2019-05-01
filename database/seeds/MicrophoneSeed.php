<?php

use App\Models\Items\ItemInstance;
use App\Models\Items\ItemStockType;
use App\Models\Items\ItemType;
use Illuminate\Database\Seeder;

class MicrophoneSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ItemType::class)->create([
            'manufacturer' => 'Sennheiser',
            'model' => 'E602',
            'stock_type' => ItemStockType::instance(),
        ])->instances()->save(factory(ItemInstance::class)->make(['label' => 'Bass Drum']));

        $sennheiserE912 = factory(ItemType::class)->create([
            'manufacturer' => 'Sennheiser',
            'model' => 'E912',
            'stock_type' => ItemStockType::instance(),
        ]);

        $sennheiserE912->instances()->save(factory(ItemInstance::class)->make(['label' => 'Piano, High sounds']));
        $sennheiserE912->instances()->save(factory(ItemInstance::class)->make(['label' => 'Piano, Low sounds']));

        factory(ItemType::class)->create([
            'manufacturer' => 'Shure',
            'model' => 'PG-41',
            'stock_type' => ItemStockType::instance(),
        ])->instances()->saveMany(factory(ItemInstance::class, 8)->make());

        factory(ItemType::class)->create([
            'manufacturer' => 'Shure',
            'model' => 'SM-57',
            'stock_type' => ItemStockType::instance(),
        ])->instances()->saveMany(factory(ItemInstance::class, 2)->make());

        factory(ItemType::class)->create([
            'manufacturer' => 'Shure',
            'model' => 'PG-81',
            'stock_type' => ItemStockType::instance(),
        ])->instances()->saveMany(factory(ItemInstance::class, 8)->make());

        factory(ItemType::class)->create([
            'manufacturer' => 'Shure',
            'model' => 'PG-81-LC',
            'stock_type' => ItemStockType::instance(),
        ])->instances()->saveMany(factory(ItemInstance::class, 6)->make());

        factory(ItemType::class)->create([
            'manufacturer' => 'AKG',
            'model' => 'C1000S',
            'stock_type' => ItemStockType::instance(),
        ])->instances()->saveMany(factory(ItemInstance::class, 2)->make());
    }
}
