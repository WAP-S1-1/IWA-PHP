<?php

namespace App\Http\Controllers;

use App\Services\MenuBuilder;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(MenuBuilder $menuBuilder): View
    {
        $user = Auth::user();
        $menuitems = $menuBuilder->buildMenuItems($user);

        return view('dashboard.index', compact('menuitems'));
    }
}
