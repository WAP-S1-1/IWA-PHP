<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class WeatherDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow request
    }

    /**
     * Rules used for request validation. This is done after prepareForValidation()
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            // Required
            'WEATHERDATA' => 'required|array|min:1',
            'WEATHERDATA.*.station' => 'required|string|max:10',
            'WEATHERDATA.*.date'    => 'required|date',
            'WEATHERDATA.*.time'    => 'required|date_format:H:i:s',

            // Optional
            'WEATHERDATA.*.temperature'          => 'nullable|numeric',
            'WEATHERDATA.*.dewpoint_temperature' => 'nullable|numeric',
            'WEATHERDATA.*.air_pressure_station' => 'nullable|numeric',
            'WEATHERDATA.*.air_pressure_sea_level'=> 'nullable|numeric',
            'WEATHERDATA.*.visibility'           => 'nullable|numeric',
            'WEATHERDATA.*.wind_speed'           => 'nullable|numeric',
            'WEATHERDATA.*.percipation'          => 'nullable|numeric',
            'WEATHERDATA.*.snow_depth'           => 'nullable|numeric',
            'WEATHERDATA.*.conditions'           => 'nullable|string|max:6',
            'WEATHERDATA.*.cloud_cover'          => 'nullable|numeric',
            'WEATHERDATA.*.wind_direction'       => 'nullable|integer',
        ];
    }

    /**
     * Prepares the received data for validation.
     * This includes mapping to keys to database names and casting the values to the correct type
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // Turn data into a collection and apply a mapping over the keys
        $mapped = collect($this->input('WEATHERDATA', []))->map(

            // Maps the keys and casts to the correct type.
            function ($item) {
                return [
                    'station'               => isset($item['STN']) ? (string) $item['STN'] : null,
                    'date'                  => $item['DATE'] ?? null,
                    'time'                  => $item['TIME'] ?? null,
                    'temperature'           => isset($item['TEMP']) ? (float) $item['TEMP'] : null,
                    'dewpoint_temperature'  => isset($item['DEWP']) ? (float) $item['DEWP'] : null,
                    'air_pressure_station'  => isset($item['STP']) ? (float) $item['STP'] : null,
                    'air_pressure_sea_level'=> isset($item['SLP']) ? (float) $item['SLP'] : null,
                    'visibility'            => isset($item['VISIB']) ? (float) $item['VISIB'] : null,
                    'wind_speed'            => isset($item['WDSP']) ? (float) $item['WDSP'] : null,
                    'percipation'           => isset($item['PRCP']) ? (float) $item['PRCP'] : null,
                    'snow_depth'            => isset($item['SNDP']) ? (float) $item['SNDP'] : null,
                    'conditions'            => isset($item['FRSHTT']) ? (string) $item['FRSHTT'] : null,
                    'cloud_cover'           => isset($item['CLDC']) ? (float) $item['CLDC'] : null,
                    'wind_direction'        => isset($item['WNDDIR']) ? (int) $item['WNDDIR'] : null,
                    ];
            }
        )->toArray();

        // Set the weatherdata to be the mapped data
        $this->merge([
            'WEATHERDATA' => $mapped
        ]);
    }
}
