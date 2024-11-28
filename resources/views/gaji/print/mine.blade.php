@foreach ($groupedGaji as $monthYear => $gajiData)
    @php
        $date = \Carbon\Carbon::createFromFormat('Y-m', $monthYear);
    @endphp
    <h1>Slip Gaji Periode {{ $date->translatedFormat('F Y') }}</h1>

    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>Jabatan:</strong> {{ $gajiData->first()?->jabatan?->nama_jabatan ?? '-' }}</p>
    <p><strong>No Rekening:</strong> {{ $user->norek }}</p>
    <p><strong>Bank:</strong> {{ $user->bank }}</p>
    <hr>
    <p><strong>Kehadiran (Total dari Data):</strong></p>
    {{-- <p><strong>Total Hari Kerja:</strong> {{ $gajiData->sum('jumlah_hari_kerja') }}</p>
    <p><strong>Jumlah Hadir:</strong> {{ $gajiData->sum('jumlah_hadir') }}</p>
    <p><strong>Jumlah WFH:</strong> {{ $gajiData->sum('jumlah_wfh') }}</p>
    <p><strong>Jumlah Izin:</strong> {{ $gajiData->sum('jumlah_izin') }}</p>
    <p><strong>Jumlah Sakit:</strong> {{ $gajiData->sum('jumlah_sakit') }}</p> --}}

    <table style="width: 100%">
        <tr>
            <td><strong>Total Hari Kerja:</strong> {{ $gajiData->sum('jumlah_hari_kerja') }}</td>
            <td><strong>Jumlah WFH:</strong> {{ $gajiData->sum('jumlah_wfh') }}</td>
        </tr>
        <tr>
            <td><strong>Jumlah Hadir:</strong> {{ $gajiData->sum('jumlah_hadir') }}</td>
            <td><strong>Jumlah Izin:</strong> {{ $gajiData->sum('jumlah_izin') }}</td>
            <td><strong>Jumlah Sakit:</strong> {{ $gajiData->sum('jumlah_sakit') }}</td>
        </tr>
    </table>

    <table border="1" cellspacing="0" cellpadding="10"
        style="width: 100%; text-align: left; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f4cccc;">
                <th>No.</th>
                <th>Komponen Gaji</th>
                <th>Jumlah Per Bulan</th>
                <th>Prorate</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Gaji Pokok</td>
                <td>{{ number_format($gajiData->first()->gaji_per_hari ?? 0, 2, ',', '.') }} x
                    {{ $gajiData->sum('jumlah_hari_kerja') }}</td>
                <td>{{ number_format($gajiData->first()->gaji_per_hari_didapat ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($gajiData->first()->gaji_per_hari_didapat ?? 0, 2, ',', '.') }}</td>
            </tr>

            <tr>
                <td>2</td>
                <td>Tunjangan Transport</td>
                <td>{{ number_format($gajiData->first()?->jabatan?->tunjangan_transportasi ?? 0, 2, ',', '.') }} x
                    {{ $gajiData->sum('jumlah_hari_kerja') }}</td>
                <td>{{ number_format($gajiData->first()->tunjangan_transport_didapat ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($gajiData->first()->tunjangan_transport_didapat ?? 0, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Tunjangan Makan</td>
                <td>{{ number_format($gajiData->first()->jabatan->tunjangan_makan ?? 0, 2, ',', '.') }} x
                    {{ $gajiData->sum('jumlah_hari_kerja') }}</td>
                <td>{{ number_format($gajiData->first()->tunjangan_makan_didapat ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($gajiData->first()->tunjangan_makan_didapat ?? 0, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Tunjangan Kesehatan</td>
                <td>{{ number_format($gajiData->first()->tunjangan_kesehatan ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($gajiData->first()->tunjangan_kesehatan ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($gajiData->first()->tunjangan_kesehatan ?? 0, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Bonus</td>
                <td>{{ number_format($gajiData->first()->bonus ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($gajiData->first()->bonus ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($gajiData->first()->bonus ?? 0, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Bonus Kinerja</td>
                <td>{{ number_format($gajiData->first()->bonus_kinerja ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($gajiData->first()->bonus_kinerja ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($gajiData->first()->bonus_kinerja ?? 0, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>7</td>
                <td>Potongan</td>
                <td>{{ number_format($gajiData->first()->potongan ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($gajiData->first()->potongan ?? 0, 2, ',', '.') }}</td>
                <td>{{ number_format($gajiData->first()->potongan ?? 0, 2, ',', '.') }}</td>
            </tr>
            <tr style="font-weight: bold; background-color: #f4cccc;">
                <td colspan="4" style="text-align: right;">Total Gaji</td>
                <td>{{ number_format($gajiData->first()->total_gaji ?? 0, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <hr>

    <script>
        window.print();
    </script>
@endforeach
