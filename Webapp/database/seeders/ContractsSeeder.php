<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;

class ContractsSeeder extends Seeder
{
        public function run(): void
    {
        $contracts = [
            [
                'company_id' => 10,
                'omschrijving' => 'Monitoring en beheer van weerstations',
                'start_datum' => '2026-01-15',
                'eind_datum' => '2027-01-15',
                'url' => 'https://example.com/contract-001',
            ],
            [
                'company_id' => 11,
                'omschrijving' => 'Real-time gegevensoverdracht metingen',
                'start_datum' => '2026-03-01',
                'eind_datum' => null, // Ongoing contract
                'url' => 'https://example.com/contract-002',
            ],
            [
                'company_id' => 12,
                'omschrijving' => 'API access voor weergegevens',
                'start_datum' => '2025-06-01',
                'eind_datum' => '2026-05-31',
                'url' => 'https://example.com/contract-003',
            ],
        ];

        foreach ($contracts as $contract) {
            Contract::create($contract);
        }
    }
    }
