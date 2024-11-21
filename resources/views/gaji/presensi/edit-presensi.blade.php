@extends('layouts.template')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h2>Edit Presensi</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.presensi.update', $presensi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tanggal_presensi">Tanggal Presensi</label>
                    <input type="date" id="tanggal_presensi" name="tanggal_presensi" class="form-control"
                        value="{{ \Carbon\Carbon::parse($presensi->datang)->format('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <label for="user_id">Nama Karyawan</label>
                    <select id="user_id" name="user_id" class="form-control" required>
                        @foreach ($karyawan as $k)
                            <option value="{{ $k->id }}" {{ $k->id == $presensi->user_id ? 'selected' : '' }}>
                                {{ $k->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status_kehadiran">Status Kehadiran</label>
                    <select id="status_kehadiran" name="status_kehadiran" class="form-control" required>
                        <option value="hadir" {{ $presensi->status_kehadiran == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="izin" {{ $presensi->status_kehadiran == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ $presensi->status_kehadiran == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="wfh" {{ $presensi->status_kehadiran == 'wfh' ? 'selected' : '' }}>WFH</option>
                        <option value="alfa" {{ $presensi->status_kehadiran == 'alfa' ? 'selected' : '' }}>Alfa</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('presensikaryawan') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
