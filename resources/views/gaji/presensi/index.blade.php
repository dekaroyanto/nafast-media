@extends('layouts.template')

@section('title', 'Presensi')

@section('content')

    <div class="card">
        <div class="card-header">
            <h1>
                @if ($status === 'datang')
                    Presensi Datang tanggal {{ $now->translatedFormat('d F Y') }}
                @elseif ($status === 'pulang')
                    Presensi Pulang tanggal {{ $now->translatedFormat('d F Y') }}
                @endif
            </h1>
        </div>
        <div class="card-body">
            <form id="presensiForm" action="{{ route('presensi') }}" method="POST">
                @csrf
                <button type="button" id="presensiButton" class="btn btn-primary">
                    Presensi
                </button>
            </form>

            @if ($status === 'pulang' && isset($presensiHariIni->lama_jam_kerja))
                <p class="mt-3">Lama Jam Kerja: <strong>{{ $presensiHariIni->lama_jam_kerja }}</strong></p>
            @endif
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h2>Riwayat Presensi</h2>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('presensi') }}" class="mb-3">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            value="{{ request('start_date') }}" placeholder="Tanggal Mulai">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">Sampai</label>
                        <input type="date" name="end_date" id="end_date" class="form-control"
                            value="{{ request('end_date') }}" placeholder="Tanggal Selesai">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary mt-4">Filter</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Waktu Datang</th>
                            <th>Waktu Pulang</th>
                            <th>Lama Jam Kerja</th>
                            <th>Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayatPresensi as $index => $presensi)
                            <tr>
                                <td>{{ $riwayatPresensi->firstItem() + $index }}</td>
                                <td>{{ \Carbon\Carbon::parse($presensi->datang)->translatedFormat('d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($presensi->datang)->format('H:i:s') }}</td>
                                <td>{{ $presensi->pulang ? \Carbon\Carbon::parse($presensi->pulang)->format('H:i:s') : '-' }}
                                </td>
                                <td>{{ $presensi->lama_jam_kerja ?? '-' }}</td>
                                <td>{{ $presensi->status_kehadiran }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data presensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-end">
                {{ $riwayatPresensi->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <script>
        document.getElementById('presensiButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Konfirmasi Presensi',
                text: "Apakah Anda yakin ingin melakukan presensi {{ $status === 'datang' ? 'datang' : 'pulang' }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Presensi!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('presensiForm').submit();
                }
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
            });
        @endif
    </script>

@endsection
