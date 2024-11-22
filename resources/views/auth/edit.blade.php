@extends('layouts.template')

@section('title', 'Edit Profile')

@section('content')
    <div class="container">
        <h1 class="my-4">Edit Profile</h1>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">No Rekening</label>
                <input type="number" class="form-control" id="norek" name="norek"
                    value="{{ old('norek', $user->norek) }}" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Bank</label>
                <input type="text" class="form-control" id="bank" name="bank"
                    value="{{ old('bank', $user->bank) }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                    value="{{ old('username', $user->username) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="{{ Auth::user()->role == 'admin' ? route('dashboard') : route('presensi') }}" type="button"
                class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
