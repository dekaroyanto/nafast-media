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
                            <label for="first-name-horizontal">Nama Jabatan</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="first-name-horizontal" class="form-control" name="nama_jabatan"
                                placeholder="Nama Jabatan">
                        </div>

                        <div class="col-md-4">
                            <label for="first-name-horizontal">Gaji Pokok</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="first-name-horizontal" class="form-control" name="gajipokok"
                                placeholder="Gaji Pokok">
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
