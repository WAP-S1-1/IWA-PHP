<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

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
        'is_corrected',
        'correction_details'
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
        'is_corrected' => 'integer',
        'correction_details' => 'array'
    ];

    public function station()
    {
        return $this->belongsTo(Station::class, 'station', 'name');
    }

    public function originalMeasurements()
    {
        return $this->hasMany(OriginalMeasurement::class, 'corrected_measurement', 'id');
    }

    public static function IncomingWeatherData()
    {
        $data = file_get_contents('php://input');

        // check voor binnekomende data
        if (empty($data)) {
            Log::warning('Geen data ontvangen via php://input');
            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'error' => 'Geen data ontvangen',
                    'message' => 'De request bevat geen data'
                ], 400)
            );
        }

        $FinalData = json_decode($data, true);

        // Controleer of de JSON geldig is
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::warning('Ongeldige JSON ontvangen', [
                'error' => json_last_error_msg(),
                'data' => substr($data, 0, 500) // Log alleen eerste 500 karakters
            ]);
            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'error' => 'Ongeldige JSON data',
                    'message' => json_last_error_msg()
                ], 400)
            );
        }


        // Return de measurement data array
        return $finalData['Measurement'] ?? [];
    }

    public static function LastThirtyWeatherData($stationId, $currentDateTime)
    {
        return self::where('STN', $stationId)
            ->whereRaw("CONCAT(DATE, ' ', TIME) < ?", [$currentDateTime])
            ->orderBy('DATE', 'DESC')
            ->orderBy('TIME', 'DESC')
            ->limit(30)
            ->get();
    }

}
