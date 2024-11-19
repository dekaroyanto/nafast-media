@extends('layouts.template')

@section('title', 'Daftar Gaji Karyawan')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container">
                <h1 class="my-4">Daftar Gaji Karyawan</h1>

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
                    <div class="d-flex justify-content-center">
                        {{ $gajiKaryawan->links() }}
                    </div>
                </div>



            </div>
        </div>
    </div>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
            })
        @endif
        @if (session('error'))
            console.log('Session error:', '{{ session('error') }}');
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        @endif
    </script>

@endsection
