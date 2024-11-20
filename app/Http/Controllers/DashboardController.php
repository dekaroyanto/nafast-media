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
        $totalGaji = GajiKaryawan::whereDate('tanggal_gaji', now()->toDateString())->sum('total_gaji');
        $userCount = User::count();
        return view('gaji.dashboard.index', compact('gajiKaryawan', 'userCount', 'totalGaji'));
    }
}
