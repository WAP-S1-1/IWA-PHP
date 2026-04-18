<?php
/*
namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\View\View;

// In MeasurementController.php

class MonitoringController extends Controller
{
    public function index(Request $request): View
    {

        $filter = $request->query('status', 'all');

        $query = Station::with('geolocations');

        if ($filter !== 'all') {
            $query->where('status', $filter);
        }
        $measurements = Measurement::where('station_id', $stationId)->get();
        $station = Station::findOrFail($stationId);

        return view('measurements.index', compact('measurements', 'station'));
    }
}
*/
