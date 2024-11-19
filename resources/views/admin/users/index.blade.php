@extends('layouts.template')

@section('title', 'Manage Users')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container">
                <h1 class="my-4">Manage Users</h1>

                <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add New User</a>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                {{-- <th>Email</th> --}}
                                {{-- <th>Username</th> --}}
                                <th>Jabatan</th>
                                {{-- <th>Role</th> --}}
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    {{-- <td>{{ $user->email }}</td> --}}
                                    {{-- <td>{{ $user->username }}</td> --}}
                                    <td>{{ $user->jabatan->nama_jabatan ?? '-' }}</td>
                                    {{-- <td>{{ ucfirst($user->role) }}</td> --}}
                                    <td>
                                        <span
                                            class="{{ $user->status == 'inactive' ? 'badge bg-light-danger' : 'badge bg-light-success' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>

                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmDelete({{ $user->id }})">Delete</button>

                                        <form id="delete-form-{{ $user->id }}"
                                            action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>

@endsection
