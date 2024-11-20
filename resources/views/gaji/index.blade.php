@extends('layouts.template')

@section('title', 'Daftar Gaji Karyawan')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container">
                <h1 class="my-4">Daftar Gaji Karyawan</h1>

                <!-- Filter dan Search -->
                <form method="GET" action="{{ route('gaji.index') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Cari Nama Karyawan</label>
                            <input type="text" name="search" id="search" class="form-control"
                                value="{{ request('search') }}" placeholder="Masukkan nama karyawan">
                        </div>
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>

                <!-- Tabel Data Gaji -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Tanggal Gaji</th>
                                <th>Jabatan</th>
                                <th>Total Gaji</th>
                                <th>Diinput Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($gajiKaryawan as $index => $gaji)
                                <tr>
                                    <td>{{ $gajiKaryawan->firstItem() + $index }}</td>
                                    <td>{{ $gaji->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($gaji->tanggal_gaji)->translatedFormat('d F Y') }}</td>
                                    <td>{{ $gaji->user->jabatan->nama_jabatan }}</td>
                                    <td>Rp {{ number_format($gaji->total_gaji, 2, ',', '.') }}</td>
                                    <td>{{ $gaji->createdBy->name ?? 'N/A' }}</td>
                                    <td style="display: flex; gap: 5px">
                                        <a href="{{ route('gaji.edit', $gaji->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $gaji->id }})">Delete</button>

                                        <form id="delete-form-{{ $gaji->id }}"
                                            action="{{ route('gaji.destroy', $gaji->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="d-flex justify-content-end">
                        {{ $gajiKaryawan->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>
@endsection
