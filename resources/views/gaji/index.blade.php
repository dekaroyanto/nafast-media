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
                                <th>Total Gaji</th>
                                <th>Diinput Oleh</th>
                                <th>Aksi</th>
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
                                    <td>Rp {{ number_format($gaji->total_gaji, 2, ',', '.') }}</td>
                                    <td>{{ $gaji->createdBy->name ?? 'N/A' }}</td>
                                    <td style="display: flex; gap: 5px">
                                        <a href="{{ route('gaji.edit', $gaji->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $gaji->id }})">Delete</button>

                                        <form id="delete-form-{{ $gaji->id }}"
                                            action="{{ route('gaji.destroy', $gaji->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
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
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>

@endsection
