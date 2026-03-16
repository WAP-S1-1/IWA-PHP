<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model

{
    protected $table = 'weather_data';

    protected $fillable = [
        'STN',
        'DATE',
        'TIME',
        'TEMP',
        'DEWP',
        'STP',
        'SLP',
        'VISIB',
        'WDSP',
        'PRCP',
        'SNDP',
        'FRSHTT',
        'CLDC',
        'WNDDIR'

    ];

    protected $casts = [
        'STN' => 'integer',
        'DATE' => 'datetime',
        'TIME' => 'string',
        'TEMP' => 'float',
        'DEWP' => 'float',
        'STP' => 'float',
        'SLP' => 'float',
        'VISIB' => 'float',
        'WDSP' => 'float',
        'PRCP' => 'float',
        'SNDP' => 'float',
        'FRSHTT' => 'string',
        'CLDC' => 'float',
        'WNDDIR' => 'integer',
    ];

    public static function IncomingWeatherData()
    {
       $Data = file_get_contents('php://input');

       if (empty($Data)) {
           http_response_code(400);
           die('Data niet goed binnengekomen');
       }

       $FinalData = json_decode($Data, true);

        if (empty($FinalData)) {
            http_response_code(400);
            die('Ongeldige JSON data');
        }

        // checken of de verplichte velden voldoen aan veldentoegestaan

        $weatherDataArray = $FinalData['WeatherData'] ?? null;

        // checken of de array niet leeg is
        if (empty($weatherDataArray) || !is_array($weatherDataArray)) {
            http_response_code(400);
            die('Ongeldige JSON data');
        }

        return $FinalData;

    }

}


