<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherGenerator;
use Illuminate\Http\Request;
use DateTime;

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
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Invalid datetime format',
                'errors' => [
                    'datetime' => ['Must be a valid date/time'],
                ],
            ], 422);
        }

        $data = WeatherGenerator::generateData(
            $dateTime,
            $validated['interval']
        );

        return response()->json($data);
    }
}
