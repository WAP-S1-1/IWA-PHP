<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Measurement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MonitoringController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->query('status', 'all');

        $query = Station::with('geolocations');

        if ($filter !== 'all') {
            $query->where('status', $filter);
        }

        $stations = $query
            ->orderByRaw("
                CASE status
                    WHEN 'red' THEN 1
                    WHEN 'orange' THEN 2
                    WHEN 'green' THEN 3
                    ELSE 4
                END
            ")
            ->paginate(12);

        return view('monitoring.index', compact('stations', 'filter'));
    }

    public function showMeasurements($station_name)
    {

        $station = Station::with('geolocations')->where('name', $station_name)->firstOrFail();

        // metingen ophalen op de naam van de station en orderen
        $measurements = Measurement::where('station', $station->name)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(20);

        return view('monitoring.measurements', compact('measurements', 'station'));
    }

}
