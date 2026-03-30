<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use App\Models\OriginalMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class WeatherDataController extends Controller
{
    // Correctieregels per parameter
    private $correctionRules = [
        'temperature' => [
            'range' => ['min' => -50, 'max' => 50],
            'correction_method' => 'clamp'
        ],
        'dewpoint_temperature' => [
            'range' => ['min' => -60, 'max' => 40],
            'correction_method' => 'clamp'
        ],
        'air_pressure_station' => [
            'range' => ['min' => 870, 'max' => 1080],
            'correction_method' => 'clamp'
        ],
        'air_pressure_sea_level' => [
            'range' => ['min' => 870, 'max' => 1080],
            'correction_method' => 'clamp'
        ],
        'visibility' => [
            'range' => ['min' => 0, 'max' => 160],
            'correction_method' => 'clamp'
        ],
        'wind_speed' => [
            'range' => ['min' => 0, 'max' => 200],
            'correction_method' => 'clamp'
        ],
        'percipation' => [
            'range' => ['min' => 0, 'max' => 500],
            'correction_method' => 'clamp'
        ],
        'cloud_cover' => [
            'range' => ['min' => 0, 'max' => 100],
            'correction_method' => 'clamp'
        ],
        'wind_direction' => [
            'range' => ['min' => 0, 'max' => 360],
            'correction_method' => 'clamp'
        ]
    ];

    private function correctValue($field, $value, $last30Records = null)
    {
        if ($value === null) {
            return [$value, false, null];
        }

        if (!isset($this->correctionRules[$field])) {
            return [$value, false, null];
        }

        $rules = $this->correctionRules[$field];
        $originalValue = $value;
        $corrected = false;
        $reason = null;

        $min = $rules['range']['min'];
        $max = $rules['range']['max'];

        if ($value < $min || $value > $max) {
            $corrected = true;

            switch ($rules['correction_method']) {
                case 'clamp':
                    $value = max($min, min($max, $value));
                    $reason = "Waarde {$originalValue} valt buiten range [{$min}-{$max}], gecorrigeerd naar {$value}";
                    break;

                case 'avg':
                    if ($last30Records && $last30Records->count() > 0) {
                        $avg = $last30Records->avg($field);
                        if ($avg !== null) {
                            $value = round($avg, 1);
                            $reason = "Waarde {$originalValue} valt buiten range, gecorrigeerd naar gemiddelde ({$avg}) van laatste 30 metingen";
                        } else {
                            $value = null;
                            $reason = "Waarde {$originalValue} valt buiten range, geen gemiddelde beschikbaar, waarde op null gezet";
                        }
                    } else {
                        $value = null;
                        $reason = "Waarde {$originalValue} valt buiten range, geen historische data, waarde op null gezet";
                    }
                    break;

                case 'null':
                    $value = null;
                    $reason = "Waarde {$originalValue} valt buiten range [{$min}-{$max}], waarde op null gezet";
                    break;
            }

            Log::info('Weerdata gecorrigeerd', [
                'field' => $field,
                'original_value' => $originalValue,
                'corrected_value' => $value,
                'reason' => $reason
            ]);
        }

        return [$value, $corrected, $reason];
    }

    // HULPMETHODES - Deze horen HIER, buiten de foreach loop!
    private function determineMissingFields($data)
    {
        $requiredFields = ['station', 'date', 'time'];
        $missing = [];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $missing[] = $field;
            }
        }

        return !empty($missing) ? implode(',', $missing) : null;
    }

    private function checkInvalidTemperature($data)
    {
        if (isset($data['temperature']) && is_numeric($data['temperature'])) {
            $temp = $data['temperature'];
            if ($temp < -50 || $temp > 50) {
                return $temp;
            }
        }

        return null;
    }

    public function getWeatherData(Request $request)
    {
        $station_id = $request["STN"];
        $currentDateTime = now();

        $recordsFromWeather = Measurement::IncomingWeatherData();
        $last30Records = Measurement::LastThirtyWeatherData($station_id, $currentDateTime);

        $recordsSaved = [];
        $anomaliesDetected = [];
        $correctionStats = [
            'total_corrections' => 0,
            'corrections_by_field' => []
        ];

        // loop door de records
        foreach ($recordsFromWeather as $raw_record) {
            // Map raw keys to fillable names
            $mapping = [
                'STN' => 'station',
                'DATE' => 'date',
                'TIME' => 'time',
                'TEMP' => 'temperature',
                'DEWP' => 'dewpoint_temperature',
                'STP' => 'air_pressure_station',
                'SLP' => 'air_pressure_sea_level',
                'VISIB' => 'visibility',
                'WDSP' => 'wind_speed',
                'PRCP' => 'percipation',
                'SNDP' => 'snow_depth',
                'FRSHTT' => 'conditions',
                'CLDC' => 'cloud_cover',
                'WNDDIR' => 'wind_direction'
            ];

            // Transform array
            $record = [];
            foreach ($mapping as $rawKey => $field) {
                $value = $raw_record[$rawKey] ?? null;

                // Cast to the correct type
                switch ($field) {
                    case 'station':
                    case 'time':
                    case 'conditions':
                        $value = is_null($value) ? null : (string) $value;
                        break;
                    case 'date':
                        $value = is_null($value) ? null : date('Y-m-d', strtotime($value));
                        break;
                    case 'wind_direction':
                        $value = is_null($value) ? null : (int) $value;
                        break;
                    default: // numeric fields
                        $value = is_null($value) ? null : (float) $value;
                }

                $record[$field] = $value;
            }

            // BEWAAR ORIGINELE DATA VOOR OriginalMeasurement
            $originalData = $record;
            $correctionsApplied = [];
            $isCorrected = false;

            $validator = Validator::make($record, [
                'station' => 'required|string',
                'date' => 'required|date',
                'time' => 'required|string',
                'temperature' => 'nullable|numeric',
                'dewpoint_temperature' => 'nullable|numeric',
                'air_pressure_station' => 'nullable|numeric',
                'air_pressure_sea_level' => 'nullable|numeric',
                'visibility' => 'nullable|numeric',
                'wind_speed' => 'nullable|numeric',
                'percipation' => 'nullable|numeric',
                'snow_depth' => 'nullable|numeric',
                'conditions' => 'nullable|string',
                'cloud_cover' => 'nullable|numeric',
                'wind_direction' => 'nullable|integer',
            ]);
            // Alleen verplichte velden controleren op errors en afwijzen
            if ($validator->fails()) {
                $requiredFields = ['station', 'date', 'time'];
                $hasFatalError = false;

                foreach ($requiredFields as $field) {
                    if ($validator->errors()->has($field)) {
                        $hasFatalError = true;
                        break;
                    }
                }

                if ($hasFatalError) {
                    return response()->json($validator->errors(), 400);
                }
            }

            // Lijst van velden die gecontroleerd moeten worden
            $fieldsToCheck = [
                'temperature', 'dewpoint_temperature', 'air_pressure_station',
                'air_pressure_sea_level', 'visibility', 'wind_speed', 'percipation',
                'cloud_cover', 'wind_direction'
            ];

            // CONTROLEER EN CORRIGEER ELK VELD
            foreach ($fieldsToCheck as $field) {
                if (isset($record[$field]) && is_numeric($record[$field])) {
                    list($correctedValue, $wasCorrected, $correctionReason) = $this->correctValue(
                        $field,
                        $record[$field],
                        $last30Records
                    );

                    if ($wasCorrected) {
                        $record[$field] = $correctedValue;
                        $isCorrected = true;
                        $correctionsApplied[] = [
                            'field' => $field,
                            'original' => $originalData[$field],
                            'corrected' => $correctedValue,
                            'reason' => $correctionReason
                        ];

                        $correctionStats['total_corrections']++;
                        if (!isset($correctionStats['corrections_by_field'][$field])) {
                            $correctionStats['corrections_by_field'][$field] = 0;
                        }
                        $correctionStats['corrections_by_field'][$field]++;
                    }
                }
            }

            // Anomalie detectie
            if (!empty($last30Records) && isset($record['temperature']) && is_numeric($record['temperature'])) {
                $values = $last30Records->pluck('temperature');

                if ($values->isNotEmpty()) {
                    $avgTemp = $values->avg();

                    $variance = $values->reduce(function ($carry, $item) use ($avgTemp) {
                            return $carry + ($item - $avgTemp) ** 2;
                        }, 0) / $values->count();

                    $stdDevTemp = sqrt($variance);
                } else {
                    $avgTemp = null;
                    $stdDevTemp = null;
                }

                if ($avgTemp && $stdDevTemp) {
                    $zScore = abs($record['temperature'] - $avgTemp) / $stdDevTemp;

                    if ($zScore > 3) {
                        $anomaliesDetected[] = [
                            'station' => $record['station'],
                            'date' => $record['date'],
                            'time' => $record['time'],
                            'temp' => $record['temperature'],
                            'avg_temp_last_30' => round($avgTemp, 2),
                            'deviation' => round($record['temperature'] - $avgTemp, 2)
                        ];

                        Log::warning('Temperatuur anomalie gedetecteerd', [
                            'station' => $record['station'],
                            'temp' => $record['temperature'],
                            'avg_temp' => $avgTemp,
                            'z_score' => $zScore
                        ]);
                    }
                }
            }

            // OPSLAAN IN MEASUREMENT TABEL
            $measurement = Measurement::updateOrCreate(
                [
                    'station' => $record['station'],
                    'date' => $record['date'],
                    'time' => $record['time']
                ],
                [
                    'temperature' => $record['temperature'] ?? null,
                    'dewpoint_temperature' => $record['dewpoint_temperature'] ?? null,
                    'air_pressure_station' => $record['air_pressure_station'] ?? null,
                    'air_pressure_sea_level' => $record['air_pressure_sea_level'] ?? null,
                    'visibility' => $record['visibility'] ?? null,
                    'wind_speed' => $record['wind_speed'] ?? null,
                    'percipation' => $record['percipation'] ?? null,
                    'snow_depth' => $record['snow_depth'] ?? null,
                    'conditions' => $record['conditions'] ?? null,
                    'cloud_cover' => $record['cloud_cover'] ?? null,
                    'wind_direction' => $record['wind_direction'] ?? null,
                    'is_corrected' => $isCorrected,
                    'correction_details' => json_encode($correctionsApplied)
                ]
            );

            // Als er correcties zijn, sla de originele data op in OriginalMeasurement
            if ($isCorrected && !empty($correctionsApplied)) {
                OriginalMeasurement::create([
                    'corrected_measurement' => $measurement->id,
                    'original_data' => $originalData,
                    'correction_reason' => json_encode($correctionsApplied),
                    'missing_field' => $this->determineMissingFields($originalData),
                    'inavlid_temperature' => $this->checkInvalidTemperature($originalData)
                ]);

                Log::info('Originele meting opgeslagen in original_measurement', [
                    'measurement_id' => $measurement->id,
                    'corrections' => $correctionsApplied
                ]);
            }

            $recordsSaved[] = $measurement;
        }

        // Return response
        return response()->json([
            'success' => true,
            'message' => count($recordsSaved) . ' weerrecords succesvol verwerkt',
            'data' => $recordsSaved,
            'meta' => [
                'last_30_records_count' => $last30Records->count(),
                'anomalies_detected' => $anomaliesDetected,
                'corrections_applied' => $correctionStats,
                'statistics' => [
                    'avg_temp' => $last30Records->avg('temperature'),
                    'max_temp' => $last30Records->max('temperature'),
                    'min_temp' => $last30Records->min('temperature'),
                    'total_records' => $last30Records->count()
                ]
            ]
        ], 201);
    }
}
