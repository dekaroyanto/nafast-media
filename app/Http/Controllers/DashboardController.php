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

        // Hitung total gaji hanya untuk bulan dan tahun saat ini
        $totalGaji = GajiKaryawan::whereYear('tanggal_gaji', now()->year)
            ->whereMonth('tanggal_gaji', now()->month)
            ->sum('total_gaji');

        $userCount = User::count();

        return view('gaji.dashboard.index', compact('gajiKaryawan', 'userCount', 'totalGaji'));
    }
}
