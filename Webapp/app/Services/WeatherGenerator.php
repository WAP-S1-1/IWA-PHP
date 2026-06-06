<?php

namespace App\Services;
use DateTime;

class WeatherGenerator
{
    private static function loadStations(): array
    {
        return require __DIR__ . '/stations.php';
    }

public static function generateData(DateTime $when, string $range): array{
    $stations = self::loadStations();

    if ($range === 'hour') {
        $start = (clone $when)->modify('-1 hour');
        $clamp = 0.5;
        $frequency = "+10 minutes";
        $end   = $when;
    } else {
        $start = (clone $when)->modify('-1 months');
        $clamp = 2.0;
        $frequency = "+1 hour";
        $end   = $when;
    }

    // ─── Generate measurements every 10 minutes ──────────────────────────────────
    function randomFloat(float $min, float $max, int $decimals = 1): float {
        return round($min + mt_rand() / mt_getrandmax() * ($max - $min), $decimals);
    }

    function clamp(float $value, float $min, float $max): float {
        return max($min, min($max, $value));
    }

    $output = [];

    foreach ($stations as $station) {
        $measurements = [];
        $current = clone $start;

        // Starting values per station
        $temp = randomFloat(24.0, 36.0);
        $cloud = randomFloat(0.0, 100.0);

        while ($current <= $end) {
            // Drift slightly each step
            $temp  = clamp($temp  + randomFloat(-1 * $clamp, $clamp), 24.0, 36.0);
            $cloud = clamp($cloud + randomFloat(-10 * $clamp, 10 * $clamp),  0.0, 100.0);

            $measurements[] = [
                'recorded_at'        => $current->format('Y-m-d H:i:s'),
                'temperature_c'      => round($temp, 1),
                'cloud_coverage_pct' => round($cloud, 1),
            ];
            $current->modify($frequency);
        }

        $output[] = [
            'station_id'   => $station['id'],
            'station_name' => $station['name'],
            'latitude'     => $station['lat'],
            'longitude'    => $station['lon'],
            'measurements' => $measurements,
        ];
    }

    return $output;
}



}
