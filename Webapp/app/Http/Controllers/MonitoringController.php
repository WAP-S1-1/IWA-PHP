<?php

namespace App\Http\Controllers;

use App\Models\Station;
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
}
