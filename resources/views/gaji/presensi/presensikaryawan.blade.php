@extends('layouts.template')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h2>Riwayat Presensi</h2>
        </div>
        <div class="card-body">
            <!-- Form Filter Tanggal -->
            <form action="{{ route('presensikaryawan') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-5">
                        <label for="start_date">Mulai Tanggal</label>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-5">
                        <label for="end_date">Sampai Tanggal</label>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                            value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Karyawan</th>
                            <th>Waktu Datang</th>
                            <th>Waktu Pulang</th>
                            <th>Lama Jam Kerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayatPresensi as $presensi)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($presensi->datang)->translatedFormat('d F Y') }}</td>
                                <td>{{ $presensi->user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($presensi->datang)->format('H:i:s') }}</td>
                                <td>{{ $presensi->pulang ? \Carbon\Carbon::parse($presensi->pulang)->format('H:i:s') : '-' }}
                                </td>
                                <td>{{ $presensi->lama_jam_kerja ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data presensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $riwayatPresensi->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
