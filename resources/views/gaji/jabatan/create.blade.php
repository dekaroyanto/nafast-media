@extends('layouts.template')

@section('title', 'Tambah Jabatan')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('jabatan.store') }}" method="POST">
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nama_jabatan">Nama Jabatan</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="nama_jabatan" class="form-control" name="nama_jabatan"
                                placeholder="Nama Jabatan" required>
                        </div>

                        <div class="col-md-4">
                            <label for="gajipokok">Gaji Pokok</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="gajipokok" class="form-control" name="gajipokok"
                                placeholder="Gaji Pokok" required>
                        </div>

                        <div class="col-md-4" hidden>
                            <label for="tunjangan_jabatan">Tunjangan Jabatan</label>
                        </div>
                        <div class="col-md-8 form-group" hidden>
                            <input type="number" id="tunjangan_jabatan" class="form-control" name="tunjangan_jabatan"
                                placeholder="Tunjangan Jabatan">
                        </div>

                        <div class="col-md-4">
                            <label for="tunjangan_kesehatan">Tunjangan Kesehatan</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="tunjangan_kesehatan" class="form-control" name="tunjangan_kesehatan"
                                placeholder="Tunjangan Kesehatan">
                        </div>

                        <div class="col-md-4">
                            <label for="tunjangan_transportasi">Tunjangan Transportasi</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="tunjangan_transportasi" class="form-control"
                                name="tunjangan_transportasi" placeholder="Tunjangan Transportasi">
                        </div>

                        <div class="col-md-4">
                            <label for="tunjangan_makan">Tunjangan Makan</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="tunjangan_makan" class="form-control" name="tunjangan_makan"
                                placeholder="Tunjangan Makan">
                        </div>

                        <div class="col-sm-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
