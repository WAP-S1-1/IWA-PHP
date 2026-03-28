<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index(Request $request)
    {
        // TODO: validate JWT token here

        // Fetch all weather stations
        $stations = Station::with(['geolocations' => function ($query) {
            $query->select('station_name', 'country', 'city'); // always include foreign key
        }])
            ->select('name', 'longitude', 'latitude', 'elevation')
            ->get();

        // Return JSON
        return response()->json([
            'stations' => $stations,
            'total' => count($stations)
        ], 200);
    }
}
