<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeatherDataRequest;
use App\Models\Measurement;
use App\Models\OriginalMeasurement;
use App\Models\Station;

class NewDataController extends Controller
{
    public function handle(WeatherDataRequest $request)
    {
        // Get validated data as defined in WeatherDataRequest
        $data = $request->validated();

        // Loop through all data points and process them
        foreach ($data['WEATHERDATA'] as $entry) {
            $this->processDataPoint($entry);
        }

        return response()->json([
            'success' => true
        ]);
    }

    private function processDataPoint(array $data){
        $missingFields = [];
        $tempCorrection = null;

        // Extrapolate data
        $extData = Measurement::getExtrapolatedData($data['station'], now());

        // Correct missing fields
        foreach ($extData as $key => $value) {
            $dataValue = $data[$key];

            if (is_null($dataValue)) {
                $missingFields[] = $key;
                $data[$key] = $value;
            }
        }

        // Correct the temperature +-20%
        if (isset($extData["temperature"])){
            $min = $extData["temperature"] * 0.8;
            $max = $extData["temperature"] * 1.2;

            $clampedValue = max($min, min($data["temperature"], $max));

            // If value changed, apply change
            if ($clampedValue != $data["temperature"]) {
                $tempCorrection = $data["temperature"];
                $data["temperature"] = $clampedValue;
            }
        }

        // Inform DB of changes
        $this->informDB($data, $missingFields, $tempCorrection);
    }

    private function informDB(array $correctData, array $missingFields, float $tempCorrection){
        // Create measurement
        $measurement = Measurement::create($correctData);


        // Inform if fields were missing
        foreach ($missingFields as $missingField) {
            OriginalMeasurement::create([
                'corrected_measurement' => $measurement->id,
                'missing_field' => $missingField,
                'inavlid_temperature' => null
            ]);
        }

        // Inform if temperature was corrected
        if (!is_null($tempCorrection)) {
            OriginalMeasurement::create([
                'corrected_measurement' => $measurement->id,
                'missing_field' => null,
                'inavlid_temperature' => $tempCorrection
            ]);
        }

        // TODO: Status is done through bad entries in last 100 packets. We need to take a better look at the status.
    }

}
