@extends('layouts.template')

@section('title', 'Laporan Harian')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Laporan Harian</h3>
            <a href="{{ route('laporan.create') }}" class="btn btn-primary">Buat Laporan</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal Laporan</th>
                        <th>Isi Laporan</th>
                        @if (auth()->user()->role === 'admin')
                            <th>Nama Karyawan</th>
                        @endif
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporans as $laporan)
                        <tr>
                            <td>{{ $laporan->tanggal_laporan }}</td>
                            <td>
                                <ul>
                                    @foreach (json_decode($laporan->isi_laporan) as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            @if (auth()->user()->role === 'admin')
                                <td>{{ $laporan->user->name }}</td>
                            @endif
                            <td>
                                <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $laporans->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
