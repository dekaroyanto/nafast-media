<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $now = now();

        // Cari data presensi hari ini
        $presensi = Presensi::where('user_id', $user->id)
            ->whereDate('datang', $now->toDateString())
            ->first();

        // Tentukan status presensi
        $status = 'datang'; // Default
        if ($presensi && $presensi->datang && !$presensi->pulang) {
            $status = 'pulang';
        }

        return view('gaji.presensi.index', compact('status', 'now'));
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

            return redirect()->route('presensi')->with('success', 'Presensi datang berhasil dicatat.');
        } elseif (!$presensi->pulang) {
            // Tambahkan waktu pulang
            $presensi->update([
                'pulang' => $now,
            ]);

            return redirect()->route('presensi')->with('success', 'Presensi pulang berhasil dicatat.');
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
