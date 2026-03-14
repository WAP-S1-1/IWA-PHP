<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Geolocation;

class GeolocationSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/geolocations.csv');

        if (!file_exists($path)) {
            $this->command->error("File not found: $path");
            return;
        }

        // Read the file as a single string
        $data = file_get_contents($path);

        // Remove trailing semicolon and whitespace
        $data = trim($data, " \n\t;");

        // Remove starting and ending parentheses if any
        $data = preg_replace("/^\(|\)$/", "", $data);

        // Split each row on '),('
        $rows = explode("),(", $data);

        foreach ($rows as $row) {
            // Parse using str_getcsv to handle quoted strings
            $columns = str_getcsv($row, ",", "'");

            // Map columns to fields
            [$id, $station_name, $country_code,
                $island, $county, $place, $hamlet, $town, $municipality,
                $state_district, $administrative, $state, $village, $region,
                $province, $city, $locality, $postcode, $country] = array_map(fn($v) => trim($v, "'"), $columns);

            Geolocation::create([
                'id' => (int) $id,
                'station_name' => $station_name,
                'country_code' => $country_code,
                'island' => $island ?: null,
                'county' => $county ?: null,
                'place' => $place ?: null,
                'hamlet' => $hamlet ?: null,
                'town' => $town ?: null,
                'municipality' => $municipality ?: null,
                'state_district' => $state_district ?: null,
                'administrative' => $administrative ?: null,
                'state' => $state ?: null,
                'village' => $village ?: null,
                'region' => $region ?: null,
                'province' => $province ?: null,
                'city' => $city ?: null,
                'locality' => $locality ?: null,
                'postcode' => $postcode ?: null,
                'country' => $country ?: null,
            ]);
        }
    }
}
