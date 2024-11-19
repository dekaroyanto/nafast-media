<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Presensi;
use App\Models\MonthlyPresence;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
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
    public function edit(Presensi $presensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presensi $presensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presensi $presensi)
    {
        //
    }
}
