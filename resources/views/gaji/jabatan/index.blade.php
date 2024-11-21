@extends('layouts.template')

@section('title', 'Jabatan')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Daftar Jabatan</h1>
        </div>
        <div class="card-body">
            {{-- Form untuk Search dan Jumlah Data --}}
            <form id="filterForm" method="GET" action="{{ route('jabatan') }}"
                class="mb-3 d-flex justify-content-between align-items-center">
                {{-- Search --}}
                <input type="text" name="search" value="{{ $search }}" id="searchInput" class="form-control w-50"
                    placeholder="Cari Jabatan...">

                {{-- Jumlah Data Per Halaman --}}
                <select name="perPage" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                </select>
            </form>

            {{-- Tabel Data --}}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Jabatan</th>
                        <th>Gaji Pokok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jabatan as $item)
                        <tr>
                            <td>{{ $item->nama_jabatan }}</td>
                            <td>{{ $item->gajipokok }}</td>
                            <td>
                                {{-- Tombol Edit --}}
                                <a href="{{ route('jabatan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                {{-- Tombol Hapus --}}
                                <button class="btn btn-danger btn-sm"
                                    onclick="confirmDelete('{{ route('jabatan.destroy', $item->id) }}')">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end align-items-center mt-3">
                <nav>
                    {{ $jabatan->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(this.delay);
            this.delay = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 700);
        });
    </script>

    <script>
        function confirmDelete(url) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form secara programatik
                    const form = document.createElement('form');
                    form.action = url;
                    form.method = 'POST';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const deleteMethod = document.createElement('input');
                    deleteMethod.type = 'hidden';
                    deleteMethod.name = '_method';
                    deleteMethod.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(deleteMethod);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
