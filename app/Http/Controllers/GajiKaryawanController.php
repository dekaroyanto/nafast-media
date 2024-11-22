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

    public function myGaji(Request $request)
    {
        $user = Auth::user();

        // Ambil data gaji hanya untuk user yang login
        $query = GajiKaryawan::with(['user.jabatan'])
            ->where('user_id', $user->id);

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_gaji', [$request->start_date, $request->end_date]);
        }

        $gajiKaryawan = $query->paginate(10);

        return view('gaji.my-gaji', compact('gajiKaryawan', 'user'));
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
            'jumlah_hari_kerja' => 'required|integer|min:1',
            'jumlah_izin' => 'nullable|integer|min:0',
            'jumlah_sakit' => 'nullable|integer|min:0',
            'jumlah_wfh' => 'nullable|integer|min:0',
            'jumlah_alfa' => 'nullable|integer|min:0',
        ]);

        $user = User::findOrFail($request->user_id);
        $jabatan = $user->jabatan;

        $gajiPerHari = ceil($jabatan->gajipokok / $request->jumlah_hari_kerja);
        $gajiPerHariDidapat = $gajiPerHari * $request->jumlah_hadir;

        $tunjanganTransportDidapat = $jabatan->tunjangan_transportasi * $request->jumlah_hadir;
        $tunjanganMakanDidapat = $jabatan->tunjangan_makan * $request->jumlah_hadir;

        $totalGaji = $gajiPerHariDidapat + $request->bonus + $tunjanganTransportDidapat + $tunjanganMakanDidapat + $jabatan->tunjangan_kesehatan - $request->potongan;

        GajiKaryawan::create([
            'user_id' => $user->id,
            'jabatan_id' => $jabatan->id,
            'tanggal_gaji' => $request->tanggal_gaji,
            'jumlah_hadir' => $request->jumlah_hadir,
            'jumlah_hari_kerja' => $request->jumlah_hari_kerja,
            'jumlah_izin' => $request->jumlah_izin,
            'jumlah_sakit' => $request->jumlah_sakit,
            'jumlah_wfh' => $request->jumlah_wfh,
            'jumlah_alfa' => $request->jumlah_alfa,
            'gaji_pokok' => $jabatan->gajipokok,
            'gaji_per_hari' => $gajiPerHari,
            'gaji_per_hari_didapat' => $gajiPerHariDidapat,
            'tunjangan_transportasi' => $jabatan->tunjangan_transportasi,
            'tunjangan_transport_didapat' => $tunjanganTransportDidapat,
            'tunjangan_makan' => $jabatan->tunjangan_makan,
            'tunjangan_makan_didapat' => $tunjanganMakanDidapat,
            'tunjangan_kesehatan' => $jabatan->tunjangan_kesehatan,
            'bonus' => $request->bonus,
            'potongan' => $request->potongan,
            'total_gaji' => $totalGaji,
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_gaji' => 'required|date',
            'jumlah_hari_kerja' => 'required|integer|min:1',
            'jumlah_hadir' => 'required|integer|min:0',
            'jumlah_izin' => 'nullable|integer|min:0',
            'jumlah_sakit' => 'nullable|integer|min:0',
            'jumlah_wfh' => 'nullable|integer|min:0',
            'jumlah_alfa' => 'nullable|integer|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
        ]);

        $gajiKaryawan = GajiKaryawan::findOrFail($id);
        $user = User::findOrFail($request->user_id);
        $jabatan = $user->jabatan;

        $gajiPerHari = ceil($jabatan->gajipokok / $request->jumlah_hari_kerja);
        $gajiPerHariDidapat = $gajiPerHari * $request->jumlah_hadir;

        $tunjanganTransportDidapat = $jabatan->tunjangan_transportasi * $request->jumlah_hadir;
        $tunjanganMakanDidapat = $jabatan->tunjangan_makan * $request->jumlah_hadir;

        $totalGaji = $gajiPerHariDidapat + $request->bonus + $tunjanganTransportDidapat + $tunjanganMakanDidapat + $jabatan->tunjangan_kesehatan - $request->potongan;

        $gajiKaryawan->update([
            'user_id' => $user->id,
            'jabatan_id' => $jabatan->id,
            'tanggal_gaji' => $request->tanggal_gaji,
            'jumlah_hari_kerja' => $request->jumlah_hari_kerja,
            'jumlah_hadir' => $request->jumlah_hadir,
            'jumlah_izin' => $request->jumlah_izin ?? 0,
            'jumlah_sakit' => $request->jumlah_sakit ?? 0,
            'jumlah_wfh' => $request->jumlah_wfh ?? 0,
            'jumlah_alfa' => $request->jumlah_alfa ?? 0,
            'gaji_pokok' => $jabatan->gajipokok,
            'gaji_per_hari' => $gajiPerHari,
            'gaji_per_hari_didapat' => $gajiPerHariDidapat,
            'tunjangan_transport_didapat' => $tunjanganTransportDidapat,
            'tunjangan_makan_didapat' => $tunjanganMakanDidapat,
            'tunjangan_kesehatan' => $jabatan->tunjangan_kesehatan,
            'bonus' => $request->bonus ?? 0,
            'potongan' => $request->potongan ?? 0,
            'total_gaji' => $totalGaji,
        ]);

        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil diperbarui.');
    }

    public function edit($id)
    {
        $gajiKaryawan = GajiKaryawan::with('user.jabatan')->findOrFail($id);
        $karyawan = User::with('jabatan')->get();

        return view('gaji.edit', compact('gajiKaryawan', 'karyawan'));
    }


    public function destroy($id)
    {
        GajiKaryawan::findOrFail($id)->delete();
        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil dihapus.');
    }

    public function printAll(Request $request)
    {
        $query = GajiKaryawan::with(['user', 'user.jabatan']);

        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_gaji', [$request->start_date, $request->end_date]);
        } else {
            // Default ke bulan saat ini
            $query->whereMonth('tanggal_gaji', now()->month)
                ->whereYear('tanggal_gaji', now()->year);
        }

        $gajiKaryawan = $query->get();

        return view('gaji.print.all', compact('gajiKaryawan'));
    }

    public function printMine(Request $request)
    {
        $user = Auth::user();
        $query = GajiKaryawan::with(['user.jabatan'])
            ->where('user_id', $user->id);

        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_gaji', [$request->start_date, $request->end_date]);
        } else {
            // Default ke bulan saat ini
            $query->whereMonth('tanggal_gaji', now()->month)
                ->whereYear('tanggal_gaji', now()->year);
        }

        $gajiKaryawan = $query->get();

        return view('gaji.print.mine', compact('gajiKaryawan', 'user'));
    }
}
