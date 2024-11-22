@extends('layouts.template')

@section('title', 'Gaji Saya')

@section('content')
    <a href="{{ route('gaji.printMine', request()->all()) }}" class="btn btn-secondary mb-3" target="_blank">Print Gaji
        Saya</a>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <h1 class="my-4">Gaji Saya</h1>

                <!-- Filter -->
                <form method="GET" action="{{ route('gaji.my') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
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
                                <th>Tanggal Gaji</th>
                                <th>Jabatan</th>
                                <th>Jumlah Hadir</th>
                                <th>Jumlah Hari Kerja</th>
                                <th>Total Gaji</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($gajiKaryawan as $index => $gaji)
                                <tr>
                                    <td>{{ $gajiKaryawan->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($gaji->tanggal_gaji)->translatedFormat('d F Y') }}</td>
                                    <td>{{ $gaji->user->jabatan->nama_jabatan }}</td>
                                    <td>{{ $gaji->jumlah_hadir }}</td>
                                    <td>{{ $gaji->jumlah_hari_kerja }}</td>
                                    <td>Rp {{ number_format($gaji->total_gaji, 2, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data tidak ditemukan.</td>
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
@endsection
