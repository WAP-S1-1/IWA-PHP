<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;

class StationController extends Controller
{
    public function index(Request $request)
    {
        // TODO: validate JWT token here

        // Fetch all weather stations
        $stations = Station::all();

        // Return JSON
        return response()->json([
            'stations' => $stations,
            'total' => count($stations)
        ], 200);
    }
}
