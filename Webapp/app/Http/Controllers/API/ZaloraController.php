<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherGenerator;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;

class ZaloraController extends Controller
{
    public function handle(Request $request)
    {
        $validated = $request->validate([
            'datetime' => ['required', 'date'],
            'interval' => ['required', 'in:hour,day,week'],
        ]);

        try {
            $dateTime = new DateTime($validated['datetime']);
        } catch (\DateMalformedStringException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'datetime' => [
                        'The datetime field must be a valid date and time.'
                    ]
                ]
            ], 422);
        }

        $data = WeatherGenerator::generateData(
            $dateTime,
            $validated['interval']
        );

        return response()->json($data);
    }
}
