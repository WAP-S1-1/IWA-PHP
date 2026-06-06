<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherGenerator;
use DateTimeZone;

class ZaloraController extends Controller
{
    public function handle()
    {
        $data = WeatherGenerator::generateData(new \DateTime("now", New DateTimeZone("CEST")), "hour");

        return response()->json($data, 200);
    }
}
