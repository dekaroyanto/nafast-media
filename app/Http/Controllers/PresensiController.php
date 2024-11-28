<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Presensi;
use Illuminate\Http\Request;
use App\Models\MonthlyPresence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function ingatkanPresensi()
    {
        $users = User::all(); // Ambil semua user

        foreach ($users as $user) {
            Mail::send('emails.reminder', ['user' => $user], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Pengingat Presensi');
            });
        }

        return back()->with('success', 'Pengingat presensi berhasil dikirim ke semua pengguna.');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $now = now();

        // Cari data presensi hari ini
        $presensiHariIni = Presensi::where('user_id', $user->id)
            ->whereDate('datang', $now->toDateString())
            ->first();

        // Ambil semua data presensi user
        $query = Presensi::where('user_id', $user->id);

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query->whereBetween('datang', [
                $startDate . ' 00:00:00', // Mulai tanggal jam 00:00:00
                $endDate . ' 23:59:59'    // Sampai tanggal jam 23:59:59
            ]);
        }

        // Order by descending and paginate
        $riwayatPresensi = $query->orderBy('datang', 'desc')->paginate(10);

        // Tentukan status presensi
        $status = 'datang'; // Default
        if ($presensiHariIni && $presensiHariIni->datang && !$presensiHariIni->pulang) {
            $status = 'pulang';
        }

        return view('gaji.presensi.index', compact('status', 'now', 'riwayatPresensi'));
    }

    public function indexadmin(Request $request)
    {
        $query = Presensi::with(['user.jabatan']); // Eager loading relasi user dan jabatan

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('datang', [$request->start_date, $request->end_date]);
        }

        // Search berdasarkan kata kunci
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%"); // Cari berdasarkan nama karyawan
                })
                    ->orWhereHas('user.jabatan', function ($subQuery) use ($search) {
                        $subQuery->where('nama_jabatan', 'like', "%{$search}%"); // Cari berdasarkan jabatan
                    })
                    ->orWhere('status_kehadiran', 'like', "%{$search}%") // Cari berdasarkan status kehadiran
                    ->orWhere('datang', 'like', "%{$search}%") // Cari berdasarkan tanggal datang
                    ->orWhere('pulang', 'like', "%{$search}%"); // Cari berdasarkan waktu pulang
            });
        }

        $riwayatPresensi = $query->orderBy('datang', 'desc')->paginate(10);

        return view('gaji.presensi.presensikaryawan', compact('riwayatPresensi'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function createByAdmin()
    {
        $karyawan = User::where('role', 'karyawan')->get();
        return view('gaji.presensi.create-presensi', compact('karyawan'));
    }

    public function storeByAdmin(Request $request)
    {
        $request->validate([
            'tanggal_presensi' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'status_kehadiran' => 'required|in:hadir,izin,sakit,wfh,alfa',
        ]);

        // Cek apakah presensi untuk tanggal ini sudah ada
        $existingPresensi = Presensi::where('user_id', $request->user_id)
            ->whereDate('datang', $request->tanggal_presensi)
            ->first();

        if ($existingPresensi) {
            return back()->with('error', 'Presensi untuk tanggal ini sudah ada.');
        }

        Presensi::create([
            'user_id' => $request->user_id,
            'datang' => Carbon::parse($request->tanggal_presensi),
            'status_kehadiran' => $request->status_kehadiran,
        ]);

        return redirect()->route('admin.presensi.create')->with('success', 'Presensi berhasil ditambahkan.');
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $now = now();

        // Cari data presensi hari ini
        $presensi = Presensi::where('user_id', $user->id)
            ->whereDate('datang', $now->toDateString())
            ->first();

        if (!$presensi) {
            // Tambahkan waktu datang
            Presensi::create([
                'user_id' => $user->id,
                'datang' => $now,
                'status_kehadiran' => 'hadir', // Default status saat presensi datang
            ]);

            // Cek atau tambahkan jumlah kehadiran untuk bulan ini
            $currentMonth = $now->month;
            $currentYear = $now->year;

            $monthlyPresence = MonthlyPresence::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'month' => $currentMonth,
                    'year' => $currentYear,
                ],
                [
                    'jumlah_hadir' => 0
                ]
            );

            // Increment jumlah hadir di bulan ini
            $monthlyPresence->increment('jumlah_hadir');

            return redirect()->route('presensi')->with('success', 'Presensi datang berhasil dicatat.');
        } elseif (!$presensi->pulang) {
            // Tambahkan waktu pulang dan hitung lama jam kerja
            $datang = Carbon::parse($presensi->datang);
            $pulang = $now;
            $duration = $datang->diff($pulang);

            $lamaJamKerja = $duration->h . ' jam ' . $duration->i . ' menit';

            $presensi->update([
                'pulang' => $pulang,
                'lama_jam_kerja' => $lamaJamKerja,
            ]);

            return redirect()->route('presensi')->with('success', 'Presensi pulang berhasil dicatat. Lama jam kerja: ' . $lamaJamKerja);
        } else {
            return redirect()->route('presensi')->with('error', 'Anda sudah melakukan presensi hari ini.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Presensi $presensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $presensi = Presensi::with('user.jabatan')->findOrFail($id);
        $karyawan = User::where('role', 'karyawan')->get();
        return view('gaji.presensi.edit-presensi', compact('presensi', 'karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_presensi' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'status_kehadiran' => 'required|in:izin,sakit,wfh,alfa,hadir',
        ]);

        $presensi = Presensi::findOrFail($id);
        $presensi->update([
            'user_id' => $request->user_id,
            'datang' => Carbon::parse($request->tanggal_presensi),
            'status_kehadiran' => $request->status_kehadiran,
        ]);

        return redirect()->route('presensikaryawan')->with('success', 'Data presensi berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $presensi = Presensi::findOrFail($id);
        $presensi->delete();

        return redirect()->route('presensikaryawan')->with('success', 'Data presensi berhasil dihapus.');
    }
}
