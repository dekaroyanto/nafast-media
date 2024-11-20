@extends('layouts.template')

@section('title', 'Input Presensi Karyawan')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Input Presensi Karyawan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.presensi.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tanggal_presensi" class="form-label">Tanggal Presensi</label>
                    <input type="date" id="tanggal_presensi" name="tanggal_presensi" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="user_id" class="form-label">Nama Karyawan</label>
                    <select id="user_id" name="user_id" class="form-control" required>
                        <option value="">Pilih Karyawan</option>
                        @foreach ($karyawan as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status_kehadiran" class="form-label">Status Kehadiran</label>
                    <select id="status_kehadiran" name="status_kehadiran" class="form-control" required>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="wfh">WFH</option>
                        <option value="alfa">Alfa</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
