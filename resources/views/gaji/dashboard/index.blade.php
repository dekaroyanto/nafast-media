@extends('layouts.template')


@section('content')
    <h1>Selamat datang, {{ Auth::user()->name }}!</h1>

    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldUser"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Users</h6>
                                    <h6 class="font-extrabold mb-0">{{ $userCount }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-6 col-lg-5 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldWallet"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Gaji</h6>
                                    <h6 class="font-extrabold mb-0">Rp {{ number_format($totalGaji, 2, ',', '.') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <div class="card">
        <div class="card-header">
            Daftar Gaji Terbaru
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Tanggal Gaji</th>
                            <th>Jumlah Hadir</th>
                            <th>Gaji Pokok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gajiKaryawan as $index => $gaji)
                            <tr>
                                <td>{{ $gajiKaryawan->firstItem() + $index }}</td>
                                <td>{{ $gaji->user->name }}</td>
                                {{-- <td>{{ $gaji->tanggal_gaji->format('d M Y') }}</td> --}}
                                <td>{{ \Carbon\Carbon::parse($gaji->tanggal_gaji)->translatedFormat('d F Y') }}</td>
                                <td>{{ $gaji->jumlah_hadir }}</td>
                                <td>Rp {{ number_format($gaji->gaji_pokok, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="d-flex justify-content-end">
                    {{ $gajiKaryawan->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    @endsection
