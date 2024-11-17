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
            <form action="{{ route('presensi.store') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Presensi</button>
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
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Waktu Datang</th>
                            <th>Waktu Pulang</th>
                            <th>Lama Jam Kerja</th>
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

    <script>
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
