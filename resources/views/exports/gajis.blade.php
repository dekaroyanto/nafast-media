<table>
    <thead>
        <tr>
            <th>Bulan</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Gaji</th>
            <!-- Tambahkan kolom lain sesuai kebutuhan -->
        </tr>
    </thead>
    <tbody>
        @foreach ($groupedGaji as $month => $items)
            @foreach ($items as $gaji)
                <tr>
                    <td>{{ $month }}</td>
                    <td>{{ $gaji->user->name }}</td>
                    <td>{{ $gaji->user->jabatan->nama }}</td>
                    <td>{{ $gaji->total_gaji }}</td>
                    <!-- Sesuaikan dengan kolom yang dibutuhkan -->
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
