<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $companies = DB::table('companies')
            ->select('*')
            ->orderBy('companies.id')
            ->get();

        return view('companies.index', compact('companies'));
    }
}
