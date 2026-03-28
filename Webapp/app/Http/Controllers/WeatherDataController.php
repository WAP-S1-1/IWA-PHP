<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\Controller;
use App\Models\WeatherData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeatherDataController extends Controller
{

    public function getWeatherData(Request $request){

        // data ophalen via de weatherdata model bestand
        $recordsFromWeather = WeatherData::IncomingWeatherData();

        $recordsSaved = [];

        // loop door de record van weatherdata heen
        foreach($recordsFromWeather as $record) {

            $validator = Validator::make($record, [
                'STN' => 'required|integer',
                'DATE' => 'required|date',
                'TIME' => 'required|string',
                'TEMP' => 'nullable|numeric',
                'DEWP' => 'nullable|numeric',
                'STP' => 'nullable|numeric',
                'SLP' => 'nullable|numeric',
                'VISIB' => 'nullable|numeric',
                'WDSP' => 'nullable|numeric',
                'PRCP' => 'nullable|numeric',
                'SNDP' => 'nullable|numeric',
                'FRSHTT' => 'nullable|string',
                'CLDC' => 'nullable|numeric',
                'WNDDIR' => 'nullable|integer',
            ]);

            // checken of validatie is gelukttt

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // later kan ik nog unieke Timestamp maken voor datum + tijd
        }
            return response ()->json([
                'succes' => true,
                'message' => count($recordsFromWeather) . ' weerrecords succesvol opgeslagen',
                'data' => $recordsFromWeather
            ], 201);
    }

}
