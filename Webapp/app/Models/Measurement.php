<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class Measurement extends Model
{
    protected $table = 'measurement';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'station',
        'date',
        'time',
        'temperature',
        'dewpoint_temperature',
        'air_pressure_station',
        'air_pressure_sea_level',
        'visibility',
        'wind_speed',
        'percipation',
        'snow_depth',
        'conditions',
        'cloud_cover',
        'wind_direction',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i:s',
        'temperature' => 'float',
        'dewpoint_temperature' => 'float',
        'air_pressure_station' => 'float',
        'air_pressure_sea_level' => 'float',
        'visibility' => 'float',
        'wind_speed' => 'float',
        'percipation' => 'float',
        'snow_depth' => 'float',
        'cloud_cover' => 'float',
        'wind_direction' => 'integer',
    ];

    public function station()
    {
        return $this->belongsTo(Station::class, 'station', 'name');
    }

    public function originalMeasurements()
    {
        return $this->hasMany(OriginalMeasurement::class, 'corrected_measurement', 'id');
    }

    // TODO: Lineair extrapolation
    public static function getExtrapolatedData($stationId, $currentDateTime): array
    {
        // Get data from the last 30 days
        $data = self::where('station', $stationId)
            ->orderBy('date', 'DESC')
            ->orderBy('time', 'DESC')
            ->limit(30)
            ->get();

        if ($data->count() == 0) {
            return [];
        }

        // Get only the extrapolatable fields
        $fields = [
            'temperature',
            'dewpoint_temperature',
            'air_pressure_station',
            'air_pressure_sea_level',
            'visibility',
            'wind_speed',
            'percipation',
            'snow_depth',
            'conditions',
            'cloud_cover',
            'wind_direction',
        ];

        $extrapolatedData = array_fill_keys($fields, null);

        foreach ($data as $entry) {
            foreach ($fields as $field) {
                $extrapolatedData[$field] += $entry->{$field};
            }
        }

        foreach ($extrapolatedData as $field => $value) {
            $extrapolatedData[$field] = $value/$data->count();
        }

        return $extrapolatedData;
    }

}
