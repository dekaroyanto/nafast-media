<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\GajiKaryawan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class GajiExport implements FromView
{
    public function view(): View
    {
        $query = GajiKaryawan::with(['user', 'user.jabatan']);

        // Default ke bulan saat ini
        $query->whereMonth('tanggal_gaji', now()->month)
            ->whereYear('tanggal_gaji', now()->year);

        $gajiKaryawan = $query->get();

        // Grouping by month
        $groupedGaji = $gajiKaryawan->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_gaji)->format('Y-m');
        });

        return view('exports.gajis', [
            'groupedGaji' => $groupedGaji
        ]);
    }
}
