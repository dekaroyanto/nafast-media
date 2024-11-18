<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;

class PresensiKaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Presensi::with('user'); // Menggunakan eager loading untuk relasi user

        // Jika ada parameter start_date dan end_date, filter presensi berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            // Mengubah format tanggal menjadi format yang sesuai dengan database (Y-m-d)
            // Menambahkan waktu '23:59:59' pada end_date untuk mencakup seluruh hari
            $query->whereBetween('datang', [
                $startDate . ' 00:00:00', // Mulai tanggal jam 00:00:00
                $endDate . ' 23:59:59'    // Sampai tanggal jam 23:59:59
            ]);
        }

        // Ambil data presensi dengan urutan terbaru
        $riwayatPresensi = $query->orderBy('datang', 'desc')->paginate(2);

        return view('gaji.presensi.presensikaryawan', compact('riwayatPresensi'));
    }
}
