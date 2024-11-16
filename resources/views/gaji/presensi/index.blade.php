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
