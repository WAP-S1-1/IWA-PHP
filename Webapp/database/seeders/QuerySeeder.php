<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Query;

class QuerySeeder extends Seeder
{
    public function run(): void
    {
        $queries = [
            [
                'contract_id' => 1,
                'omschrijving' => 'Alle Nederlandse stations boven 10m hoogte',
            ],
            [
                'contract_id' => 1,
                'omschrijving' => 'Stations in Noord-Holland met uurlijkse frequentie',
            ],
            [
                'contract_id' => 2,
                'omschrijving' => 'Alle stations met realtime data',
            ],
        ];

        foreach ($queries as $query) {
            Query::create($query);
        }
    }
}
