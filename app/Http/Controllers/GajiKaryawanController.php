<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Presensi;
use App\Models\GajiKaryawan;
use Illuminate\Http\Request;
use App\Models\MonthlyPresence;
use Illuminate\Support\Facades\Auth;

class GajiKaryawanController extends Controller
{

    public function index(Request $request)
    {
        $query = GajiKaryawan::with(['user', 'user.jabatan', 'createdBy']);

        // Filter berdasarkan nama karyawan
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_gaji', [$request->start_date, $request->end_date]);
        }

        $gajiKaryawan = $query->paginate(10);

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
            'jumlah_izin' => 'required|integer',
            'jumlah_sakit' => 'required|integer',
            'jumlah_wfh' => 'required|integer',
            'jumlah_alfa' => 'required|integer',
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
            'jumlah_izin' => $request->jumlah_izin,
            'jumlah_sakit' => $request->jumlah_sakit,
            'jumlah_wfh' => $request->jumlah_wfh,
            'jumlah_alfa' => $request->jumlah_alfa,
            'gaji_pokok' => $jabatan->gajipokok,
            'bonus' => $request->bonus ?? 0,
            'potongan' => $request->potongan ?? 0,
            'total_gaji' => ($jabatan->gajipokok + ($request->bonus ?? 0)) - ($request->potongan ?? 0),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('gaji.create')->with('success', 'Data gaji berhasil ditambahkan.');
    }

    public function fetchJumlahPresensi($user_id, $year, $month)
    {
        $data = Presensi::where('user_id', $user_id)
            ->whereYear('datang', $year)
            ->whereMonth('datang', $month)
            ->selectRaw("
                COUNT(CASE WHEN status_kehadiran = 'hadir' THEN 1 END) AS jumlah_hadir,
                COUNT(CASE WHEN status_kehadiran = 'izin' THEN 1 END) AS jumlah_izin,
                COUNT(CASE WHEN status_kehadiran = 'sakit' THEN 1 END) AS jumlah_sakit,
                COUNT(CASE WHEN status_kehadiran = 'wfh' THEN 1 END) AS jumlah_wfh,
                COUNT(CASE WHEN status_kehadiran = 'alfa' THEN 1 END) AS jumlah_alfa
            ")
            ->first();

        return response()->json($data);
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
            'jumlah_izin' => 'required|integer',
            'jumlah_sakit' => 'required|integer',
            'jumlah_wfh' => 'required|integer',
            'jumlah_alfa' => 'required|integer',
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
            'jumlah_izin' => $request->jumlah_izin,
            'jumlah_sakit' => $request->jumlah_sakit,
            'jumlah_wfh' => $request->jumlah_wfh,
            'jumlah_alfa' => $request->jumlah_alfa,
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
