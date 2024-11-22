<h1>Slip Gaji Saya</h1>

<p><strong>Nama:</strong> {{ $user->name }}</p>
<p><strong>Jabatan:</strong> {{ $user->jabatan->nama_jabatan }}</p>

<table border="1" cellspacing="0" cellpadding="10" style="width: 100%; text-align: left;">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Gaji</th>
            <th>Jumlah Hadir</th>
            <th>Jumlah Hari Kerja</th>
            <th>Total Gaji</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($gajiKaryawan as $index => $gaji)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($gaji->tanggal_gaji)->format('d M Y') }}</td>
                <td>{{ $gaji->jumlah_hadir }}</td>
                <td>{{ $gaji->jumlah_hari_kerja }}</td>
                <td>Rp {{ number_format($gaji->total_gaji, 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    window.print();
</script>