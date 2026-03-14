<?php

namespace App\Http\Controllers;

class UserManagementController extends Controller
{
    public function index(): view{
        return view('gebruiker.index');
    }

}
