<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index(Request $request)
    {
//        // Update status voor alle stations op basis van laatste metingen
//        $allStations = Station::all();
//        foreach ($allStations as $station) {
//            $station->updateStatusBasedOnMeasurements();
//        }

        // Fetch all weather stations
        $stations = Station::with(['latestMeasurement', 'geolocations'])
            ->get();

        // ChatGPT generated
        // Get last measurement and check if it is online
        foreach ($stations as $station) {
            $last = $station->latestMeasurement;

            var_dump((!$last || now()->diffInSeconds(
                    \Carbon\Carbon::parse($last->date . ' ' . $last->time)
                )));

            $station->status = (!$last || now()->diffInSeconds(
                    \Carbon\Carbon::parse($last->date . ' ' . $last->time)
                ) > 300) ? 3 : 0;
        }

//        // Tel stations per status voor summary
//        $statusCounts = [
//            'green' => $stations->where('status', Station::STATUS_GREEN)->count(),
//            'orange' => $stations->where('status', Station::STATUS_ORANGE)->count(),
//            'red' => $stations->where('status', Station::STATUS_RED)->count()
//        ];

        // Return JSON
        return response()->json([
            'stations' => $stations,
            'total' => count($stations),
            //'summary' => $statusCounts
        ], 200);
    }

    /**
     * Get station details with recent measurements
     */
    public function show($name)
    {
        // TODO: validate JWT token here

        $station = Station::with(['geolocations' => function ($query) {
            $query->select('station_name', 'country', 'city');
        }, 'measurements' => function ($query) {
            $query->orderBy('date', 'DESC')
                ->orderBy('time', 'DESC')
                ->limit(30);
        }])
            ->where('name', $name)
            ->select('name', 'longitude', 'latitude', 'elevation', 'status', 'status_message', 'status_updated_at')
            ->firstOrFail();

        // Update status op basis van laatste metingen
        $station->updateStatusBasedOnMeasurements();

        return response()->json([
            'success' => true,
            'station' => $station
        ], 200);
    }

    /**
     * Get stations filtered by status
     */
    public function getFilteredStations(Request $request)
    {
        // TODO: validate JWT token here

        $status = $request->get('status', 'all');

        $query = Station::with(['geolocations' => function ($query) {
            $query->select('station_name', 'country', 'city');
        }])
            ->select('name', 'longitude', 'latitude', 'elevation', 'status', 'status_message', 'status_updated_at');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Sorteer op status (rood eerst, dan oranje, dan groen)
        $stations = $query->orderByRaw("
            CASE status
                WHEN 'red' THEN 1
                WHEN 'orange' THEN 2
                WHEN 'green' THEN 3
                ELSE 4
            END
        ")->get();

        $statusCounts = [
            'green' => Station::where('status', Station::STATUS_GREEN)->count(),
            'orange' => Station::where('status', Station::STATUS_ORANGE)->count(),
            'red' => Station::where('status', Station::STATUS_RED)->count()
        ];

        return response()->json([
            'success' => true,
            'stations' => $stations,
            'current_filter' => $status,
            'summary' => $statusCounts
        ], 200);
    }
}
