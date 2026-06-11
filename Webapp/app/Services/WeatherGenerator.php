<?php

namespace App\Services;
use DateTime;

class WeatherGenerator
{
    private static function loadStations(): array
    {
        return require __DIR__ . '/stations.php';
    }

    public static function generateData(DateTime $when, string $range): array
    {
        $stations = self::loadStations();

        if ($range === 'hour') {
            $start      = (clone $when)->modify('-1 hour');
            $frequency  = '+10 minutes';
            $end        = $when;
            $driftDecay = 0.85; // gentle decay — short window, smooth curve
            $driftNoise = 1.2;
        } else {
            $start      = (clone $when)->modify('-2 months');
            $frequency  = '+12 hours';
            $end        = $when;
            $driftDecay = 0.60; // aggressive decay — stops multi-day random walks
            $driftNoise = 0.8;  // smaller per-step noise; variation comes from many steps
        }

        $output = [];

        foreach ($stations as $station) {
            // Each station gets its own baseline so they feel distinct.
            // Tropical range roughly 26–34°C; baseline is the "typical midday peak" for this station.
            $stationBaseline = self::randomFloat(28.0, 34.0);

            $measurements = [];
            $current      = clone $start;

            // Seed drift values
            $tempDrift  = 0.0;
            $cloud      = self::randomFloat(10.0, 70.0);

            while ($current <= $end) {
                // ── Diurnal cycle ──────────────────────────────────────────────
                // Peaks around 14:00 (+4°C above baseline), troughs around 05:00 (−4°C).
                $hour         = (int) $current->format('G') + ((int) $current->format('i') / 60);
                $diurnalPhase = ($hour - 14) * (M_PI / 12); // shift so peak = 14h
                $diurnal      = -4.0 * cos($diurnalPhase);  // −cos so max at phase=0

                // ── Cloud drift ────────────────────────────────────────────────
                // Clouds drift with a mean-reversion tendency toward 40% (partly cloudy).
                $cloudMeanReversion = (40.0 - $cloud) * 0.05;
                $cloud = self::clamp(
                    $cloud + $cloudMeanReversion + self::randomFloat(-8.0, 8.0),
                    0.0,
                    100.0
                );

                // ── Temperature drift ──────────────────────────────────────────
                // Heavy cloud cover suppresses the daytime peak by up to −3°C.
                $cloudSuppression = -($cloud / 100.0) * 3.0;

                // Drift mean-reverts toward 0 so we don't random-walk off the range.
                $tempDrift = $tempDrift * $driftDecay + self::randomFloat(-$driftNoise, $driftNoise);

                $rawTemp = $stationBaseline + $diurnal + $cloudSuppression + $tempDrift;

                // Soft ceiling: values approaching the limits get gently squeezed rather
                // than hitting a hard wall, so 38°C almost never appears exactly.
                $temp = self::softClamp($rawTemp, 22.0, 37.5, 2.5);

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

    private static function randomFloat(float $min, float $max): float
    {
        return $min + (mt_rand() / mt_getrandmax()) * ($max - $min);
    }

    private static function clamp(float $value, float $min, float $max): float
    {
        return max($min, min($max, $value));
    }

    /**
     * Like clamp, but within $margin of each boundary the value is smoothly
     * compressed via a sigmoid so it asymptotically approaches the limit
     * instead of hitting it hard.
     */
    private static function softClamp(float $value, float $min, float $max, float $margin): float
    {
        // Squish near the upper boundary
        if ($value > $max - $margin) {
            $excess = $value - ($max - $margin);
            $value  = ($max - $margin) + $margin * (2 / (1 + exp(-2 * $excess / $margin)) - 1);
        }
        // Squish near the lower boundary
        if ($value < $min + $margin) {
            $deficit = ($min + $margin) - $value;
            $value   = ($min + $margin) - $margin * (2 / (1 + exp(-2 * $deficit / $margin)) - 1);
        }
        return $value;
    }
}
