<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'id' => 10,
                'name' => 'Schiphol Airport',
                'city' => 'Schiphol',
                'street' => 'Aankomstpassage',
                'number' => 1,
                'number_additional' => null,
                'zip_code' => '1118AX',
                'country' => 'NL',
                'email' => 'schiphol@schiphol.nl',
            ],
            [
                'id' => 11,
                'name' => 'Eelde Groningen Airport',
                'city' => 'Eelde',
                'street' => 'Machlaan',
                'number' => 14,
                'number_additional' => 'A',
                'zip_code' => '9761TK',
                'country' => 'NL',
                'email' => 'groningenAirport@eeldeairport.nl',
            ],
            [
                'id' => 12,
                'name' => 'KNMI weerstation Eelde',
                'city' => 'Eelde',
                'street' => 'Burgemeester J.G. Legroweg',
                'number' => 35,
                'number_additional' => null,
                'zip_code' => '9761KT',
                'country' => 'NL',
                'email' => 'knmi@eeldeairport.nl',
            ],
            [
                'id' => 13,
                'name' => 'HSB Hochschule Bremen',
                'city' => 'Bremen',
                'street' => 'Neustadtswall',
                'number' => 30,
                'number_additional' => null,
                'zip_code' => '28199',
                'country' => 'DE',
                'email' => 'wetter@hsb.bremen.de',
            ],
        ]);
    }
}
