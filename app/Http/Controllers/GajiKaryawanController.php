<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\GajiKaryawan;
use Illuminate\Http\Request;
use App\Models\MonthlyPresence;

class GajiKaryawanController extends Controller
{

    public function index()
    {
        $gajiKaryawan = GajiKaryawan::with('user')->paginate(10);
        return view('gaji.index', compact('gajiKaryawan'));
    }

    public function create()
    {
        $karyawan = User::with('jabatan')->get(); // Ambil data karyawan beserta jabatan
        return view('gaji.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_gaji' => 'required|date',
            'jumlah_hadir' => 'required|integer',
            'gaji_pokok' => 'required|numeric',
        ]);

        $user = User::findOrFail($request->user_id);
        $jabatan = $user->jabatan;

        GajiKaryawan::create([
            'user_id' => $user->id,
            'jabatan_id' => $jabatan->id,
            'tanggal_gaji' => $request->tanggal_gaji,
            'jumlah_hadir' => $request->jumlah_hadir,
            'gaji_pokok' => $jabatan->gajipokok,
        ]);

        return redirect()->route('gaji.create')->with('success', 'Data gaji berhasil ditambahkan.');
    }

    public function fetchJumlahHadir($user_id, $year, $month)
    {
        $jumlahHadir = MonthlyPresence::where('user_id', $user_id)
            ->where('year', $year)
            ->where('month', $month)
            ->value('jumlah_hadir') ?? 0;

        return response()->json(['jumlah_hadir' => $jumlahHadir]);
    }
}
