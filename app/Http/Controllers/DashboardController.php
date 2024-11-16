<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function menu()
    {
        return view('welcome');
    }
    public function index()
    {
        return view('gaji.dashboard.index');
    }
}
