<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Station;

class StationSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/stations.csv');

        if (!file_exists($path)) {
            $this->command->error("File not found: $path");
            return;
        }

        // Read the file as a single string
        $data = file_get_contents($path);

        // Remove parentheses and split on '),('
        $data = trim($data, " \n\t;"); // remove trailing semicolon
        $data = preg_replace("/^\(|\)$/", "", $data); // remove starting/ending parentheses
        $rows = explode("),(", $data);

        foreach ($rows as $row) {
            // Split by comma
            $columns = str_getcsv($row, ",", "'");
            [$name, $longitude, $latitude, $elevation] = $columns;

            Station::create([
                'name' => trim($name, "'"), // remove quotes
                'longitude' => (float) $longitude,
                'latitude' => (float) $latitude,
                'elevation' => (float) $elevation,
            ]);
        }
    }
}
