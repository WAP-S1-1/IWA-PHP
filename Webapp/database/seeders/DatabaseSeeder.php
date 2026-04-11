<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ProjectWebSeeder::class,
            CountrySeeder::class,
            StationSeeder::class,
            GeolocationSeeder::class,
            CompanySeeder::class,
            SubscriptionTypesSeeder::class,
            SubscriptionsSeeder::class,
            SubscriptionStationSeeder::class,
            ContractsSeeder::class,
            QuerySeeder::class,
        ]);
    }
}
