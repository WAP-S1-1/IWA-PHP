<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\View\View;

class MonitoringController extends Controller
{
    public function index(): View
    {
        // Paginate, e.g., 12 stations per page
        $stations = Station::with('geolocations')->paginate(12);

        return view('monitoring.index', compact('stations'));
    }
}
