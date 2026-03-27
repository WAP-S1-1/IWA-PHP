<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            StationSeeder::class,
            CompaniesSeeder::class,
            SubscriptionTypesSeeder::class,

            SubscriptionsSeeder::class,
            SubscriptionStationSeeder::class,
        ]);

    }
}
