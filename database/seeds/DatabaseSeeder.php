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

        $this->call([
            MicrophoneSeed::class,
            FakeSeed::class
        ]);
    }
}
