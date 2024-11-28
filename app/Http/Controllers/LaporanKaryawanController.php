<?php

namespace App\Http\Controllers;

use App\Models\LaporanKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query dasar untuk semua laporan
        $query = LaporanKaryawan::with('user')->orderBy('tanggal_laporan', 'desc');

        // Jika karyawan, filter laporan sesuai kebutuhan
        if (Auth::user()->role === 'karyawan') {
            $query->where(function ($q) {
                $q->where('user_id', Auth::id()) // Laporan milik user sendiri
                    ->orWhereHas('user', function ($subQuery) {
                        $subQuery->where('role', 'karyawan'); // Laporan dari karyawan lain
                    });
            });
        }

        // Menambahkan fitur pencarian jika diperlukan
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Paginate hasil
        $laporans = $query->paginate(10);

        return view('gaji.laporan.index', compact('laporans'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gaji.laporan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_laporan' => 'required|date',
            'isi_laporan' => 'required|array',
            'isi_laporan.*' => 'required|string',
        ]);

        LaporanKaryawan::create([
            'user_id' => Auth::id(),
            'tanggal_laporan' => $request->tanggal_laporan,
            'isi_laporan' => json_encode($request->isi_laporan), // Menyimpan sebagai JSON
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan harian berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanKaryawan $laporanKaryawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $laporan = LaporanKaryawan::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $laporan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $laporan->isi_laporan = json_decode($laporan->isi_laporan); // Decode JSON untuk tampilan edit
        return view('gaji.laporan.edit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $laporan = LaporanKaryawan::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $laporan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'tanggal_laporan' => 'required|date',
            'isi_laporan' => 'required|array',
            'isi_laporan.*' => 'required|string',
        ]);

        $laporan->update([
            'tanggal_laporan' => $request->tanggal_laporan,
            'isi_laporan' => json_encode($request->isi_laporan),
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan harian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laporan = LaporanKaryawan::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $laporan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan harian berhasil dihapus.');
    }
}
