@extends('layouts.template')

@section('title', 'Add New User')

@section('content')
    <div class="container">
        <h1 class="my-4">Add New User</h1>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">No Rekening</label>
                <input type="number" class="form-control" id="norek" name="norek" value="{{ old('norek') }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Bank</label>
                <input type="text" class="form-control" id="name" name="bank" value="{{ old('bank') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    required>
            </div>
            <div class="mb-3">
                <label for="jabatan_id" class="form-label">Jabatan</label>
                <select name="jabatan_id" id="jabatan_id" class="form-control" required>
                    <option value="">Select Jabatan</option>
                    @foreach ($jabatans as $jabatan)
                        <option value="{{ $jabatan->id }}" {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                            {{ $jabatan->nama_jabatan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
    </div>
@endsection
