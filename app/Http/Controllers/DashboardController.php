<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GajiKaryawan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function menu()
    {
        return view('welcome');
    }
    public function index()
    {
        $gajiKaryawan = GajiKaryawan::with('user')->paginate(5);
        $totalGaji = GajiKaryawan::sum('gaji_pokok');
        $userCount = User::count();
        return view('gaji.dashboard.index', compact('gajiKaryawan', 'userCount', 'totalGaji'));
    }
}
