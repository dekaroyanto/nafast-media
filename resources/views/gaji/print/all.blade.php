<h1>Daftar Gaji Karyawan</h1>

<table border="1" cellspacing="0" cellpadding="10" style="width: 100%; text-align: left;">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Tanggal Gaji</th>
            <th>Jabatan</th>
            <th>Jumlah Hadir</th>
            <th>Jumlah Hari Kerja</th>
            <th>Total Gaji</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($gajiKaryawan as $index => $gaji)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $gaji->user->name }}</td>
                <td>{{ \Carbon\Carbon::parse($gaji->tanggal_gaji)->format('d M Y') }}</td>
                <td>{{ $gaji->user->jabatan->nama_jabatan }}</td>
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
