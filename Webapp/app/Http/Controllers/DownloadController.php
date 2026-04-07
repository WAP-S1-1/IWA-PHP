<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DownloadController extends Controller
{
    public function index(): View{
        return view('download.index');
    }
}
