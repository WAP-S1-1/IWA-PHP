<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(): View{
        return view('companies.index');
    }
}
