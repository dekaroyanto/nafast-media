<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\GajiKaryawan;
use Illuminate\Http\Request;
use App\Models\MonthlyPresence;
use Illuminate\Support\Facades\Auth;

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
            'bonus' => 'nullable|numeric',
            'potongan' => 'nullable|numeric',
        ]);

        $user = User::findOrFail($request->user_id);
        $jabatan = $user->jabatan;

        GajiKaryawan::create([
            'user_id' => $user->id,
            'jabatan_id' => $jabatan->id,
            'tanggal_gaji' => $request->tanggal_gaji,
            'jumlah_hadir' => $request->jumlah_hadir,
            'gaji_pokok' => $jabatan->gajipokok,
            'bonus' => $request->bonus ?? 0,
            'potongan' => $request->potongan ?? 0,
            'total_gaji' => ($jabatan->gajipokok + ($request->bonus ?? 0)) - ($request->potongan ?? 0),
            'created_by' => Auth::id(),
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

    public function edit($id)
    {
        $gajiKaryawan = GajiKaryawan::with('user.jabatan')->findOrFail($id);
        $karyawan = User::with('jabatan')->get();
        return view('gaji.edit', compact('gajiKaryawan', 'karyawan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_gaji' => 'required|date',
            'jumlah_hadir' => 'required|integer',
            'gaji_pokok' => 'required|numeric',
            'bonus' => 'nullable|numeric',
            'potongan' => 'nullable|numeric',
        ]);

        $gajiKaryawan = GajiKaryawan::findOrFail($id);
        $user = User::findOrFail($request->user_id);
        $jabatan = $user->jabatan;

        $gajiKaryawan->update([
            'user_id' => $user->id,
            'jabatan_id' => $jabatan->id,
            'tanggal_gaji' => $request->tanggal_gaji,
            'jumlah_hadir' => $request->jumlah_hadir,
            'gaji_pokok' => $jabatan->gajipokok,
            'bonus' => $request->bonus ?? 0,
            'potongan' => $request->potongan ?? 0,
            'total_gaji' => ($jabatan->gajipokok + ($request->bonus ?? 0)) - ($request->potongan ?? 0),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil diperbarui.');
    }

    public function destroy($id)
    {
        GajiKaryawan::findOrFail($id)->delete();
        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil dihapus.');
    }
}
