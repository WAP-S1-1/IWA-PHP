<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class WeatherData extends Model

{
    protected $table = 'measurements';


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


