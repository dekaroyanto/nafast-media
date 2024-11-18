<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiKaryawan extends Controller
{
    public function index()
    {
        $presensikaryawan = Presensi::all();
        return view('gaji.presensi.presensikaryawan', compact('presensikaryawan'));
    }
}
