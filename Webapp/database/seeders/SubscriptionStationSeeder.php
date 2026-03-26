<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionStationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subscription_station')->insert([
            ['subscription' => 1, 'station' => '62250'],
            ['subscription' => 1, 'station' => '62350'],
            ['subscription' => 1, 'station' => '62400'],
            ['subscription' => 1, 'station' => '63300'],

            ['subscription' => 2, 'station' => '62500'],
            ['subscription' => 2, 'station' => '62680'],

            ['subscription' => 3, 'station' => '62500'],
            ['subscription' => 3, 'station' => '62680'],
        ]);
    }
}
