<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NearestLocation;

class NearestLocationSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/nearestlocation.csv');

        if (!file_exists($path)) {
            $this->command->error("File not found: {$path}");
            return;
        }

        $content = file_get_contents($path);

        // Split into individual records: (...),(...)...
        preg_match_all('/\(([^)]+)\)/', $content, $matches);

        foreach ($matches[1] as $row) {

            // Split CSV safely with quoted strings
            $values = str_getcsv($row, ',', "'");

            if (count($values) < 8) {
                continue;
            }

            NearestLocation::updateOrCreate(
                ['id' => (int) $values[0]],
                [
                    'station_name' => $values[1],
                    'name' => $values[2] ?: null,
                    'administrative_region1' => $values[3] ?: null,
                    'administrative_region2' => $values[4] ?: null,
                    'country_code' => $values[5],
                    'longitude' => (float) $values[6],
                    'latitude' => (float) $values[7],
                ]
            );
        }

        $this->command->info('Nearest locations imported successfully.');
    }
}
