@extends('layouts.template')

@section('title', 'Laporan Harian')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Laporan Harian</h3>
            <a href="{{ route('laporan.create') }}" class="btn btn-primary">Buat Laporan</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal Laporan</th>
                            <th>Isi Laporan</th>

                            <th>Nama Karyawan</th>
                            @if ($laporans->contains('user_id', Auth::id()))
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporans as $laporan)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->translatedFormat('d F Y') }}</td>
                                <td>
                                    <ul>
                                        @foreach (json_decode($laporan->isi_laporan) as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                </td>

                                <td>{{ $laporan->user->name }}</td>

                                @if ($laporan->user_id === Auth::id())
                                    <td style="display: flex; align-items: center; justify-content: center; gap: 10px;">

                                        <a href="{{ route('laporan.edit', $laporan->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">Hapus</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $laporans->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
