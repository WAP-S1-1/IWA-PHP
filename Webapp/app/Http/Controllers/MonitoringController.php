<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MonitoringController extends Controller
{
    public function index(): View{
        return view('monitoring.index');
    }
}
