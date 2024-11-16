<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil jumlah data per halaman dari request atau default 10
        $perPage = $request->get('perPage', 10);

        // Ambil keyword search dari request
        $search = $request->get('search', '');

        // Query untuk mendapatkan data jabatan dengan filter search
        $jabatan = Jabatan::where('nama_jabatan', 'like', "%$search%")
            ->orWhere('gajipokok', 'like', "%$search%")
            ->paginate($perPage)
            ->withQueryString(); // Agar query params tetap ada pada pagination links

        return view('gaji.jabatan.index', compact('jabatan', 'perPage', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gaji.jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required',
            'gajipokok' => 'required',
        ], [
            'nama_jabatan.required' => 'Nama jabatan harus diisi',
            'gajipokok.required' => 'Gaji Pokok harus diisi',
        ]);

        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
            'gajipokok' => $request->gajipokok,
        ]);

        return redirect()->route('jabatan')->with('success', 'Jabatan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'gajipokok' => 'required|numeric',
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($request->only(['nama_jabatan', 'gajipokok']));

        return redirect()->route('jabatan.index')->with('success', 'Data jabatan berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('jabatan')->with('success', 'Data jabatan berhasil dihapus!');
    }
}
