@extends('layouts.template')

@section('title', 'Edit Jabatan')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nama_jabatan">Nama Jabatan</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="nama_jabatan" class="form-control" name="nama_jabatan"
                                value="{{ $jabatan->nama_jabatan }}" placeholder="Nama Jabatan" required>
                        </div>

                        <div class="col-md-4">
                            <label for="gajipokok">Gaji Pokok</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="gajipokok" class="form-control" name="gajipokok"
                                value="{{ $jabatan->gajipokok }}" placeholder="Gaji Pokok" required>
                        </div>

                        <div class="col-md-4" hidden>
                            <label for="tunjangan_jabatan">Tunjangan Jabatan</label>
                        </div>
                        <div class="col-md-8 form-group" hidden>
                            <input type="number" id="tunjangan_jabatan" class="form-control" name="tunjangan_jabatan"
                                value="{{ $jabatan->tunjangan_jabatan }}" placeholder="Tunjangan Jabatan">
                        </div>

                        <div class="col-md-4">
                            <label for="tunjangan_kesehatan">Tunjangan Kesehatan</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="tunjangan_kesehatan" class="form-control" name="tunjangan_kesehatan"
                                value="{{ $jabatan->tunjangan_kesehatan }}" placeholder="Tunjangan Kesehatan">
                        </div>

                        <div class="col-md-4">
                            <label for="tunjangan_transportasi">Tunjangan Transportasi</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="tunjangan_transportasi" class="form-control"
                                name="tunjangan_transportasi" value="{{ $jabatan->tunjangan_transportasi }}"
                                placeholder="Tunjangan Transportasi">
                        </div>

                        <div class="col-md-4">
                            <label for="tunjangan_makan">Tunjangan Makan</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="tunjangan_makan" class="form-control" name="tunjangan_makan"
                                value="{{ $jabatan->tunjangan_makan }}" placeholder="Tunjangan Makan">
                        </div>

                        <div class="col-sm-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan Perubahan</button>
                            <a href="{{ route('jabatan') }}" class="btn btn-secondary me-1 mb-1">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
