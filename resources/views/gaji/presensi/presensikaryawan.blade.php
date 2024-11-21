@extends('layouts.template')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h2>Riwayat Presensi</h2>
        </div>
        <div class="card-body">
            <a href="{{ route('admin.presensi.create') }}" class="btn btn-primary mb-4">Tambah Presensi</a>

            <!-- Form Search dan Filter -->
            <form action="{{ route('presensikaryawan') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label for="search">Pencarian</label>
                        <input type="text" id="search" name="search" class="form-control"
                            placeholder="Cari data presensi..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="start_date">Mulai Tanggal</label>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date">Sampai Tanggal</label>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                            value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">Cari.....</button>
                        <a href="{{ route('presensikaryawan') }}" type="button" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Nama Karyawan</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">Waktu Datang</th>
                            <th class="text-center">Waktu Pulang</th>
                            <th class="text-center">Lama Jam Kerja</th>
                            <th class="text-center">Status Kehadiran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayatPresensi as $presensi)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($presensi->datang)->translatedFormat('d F Y') }}</td>
                                <td>{{ $presensi->user->name }}</td>
                                <td class="text-center">{{ $presensi->user->jabatan->nama_jabatan ?? 'Belum diatur' }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($presensi->datang)->format('H:i:s') }}</td>
                                <td class="text-center">
                                    {{ $presensi->pulang ? \Carbon\Carbon::parse($presensi->pulang)->format('H:i:s') : '-' }}
                                </td>
                                <td class="text-center">{{ $presensi->lama_jam_kerja ?? '-' }}</td>
                                <td class="text-center">{{ $presensi->status_kehadiran }}</td>
                                <td style="display: flex; gap: 5px">
                                    <a href="{{ route('admin.presensi.edit', $presensi->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="confirmDelete({{ $presensi->id }})">Hapus</button>

                                    <form id="delete-form-{{ $presensi->id }}"
                                        action="{{ route('admin.presensi.destroy', $presensi->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data presensi.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-end">
                {{ $riwayatPresensi->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data ini tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>
@endsection
