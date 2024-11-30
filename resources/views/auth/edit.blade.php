@extends('layouts.template')

@section('title', 'Edit Profile')

@section('content')
    <div class="container">
        <h1 class="my-4">Edit Profile</h1>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $user->name) }}" required>
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

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*"
                    onchange="previewAvatar(event)">
                <small class="text-muted">Ukuran maksimal 2MB. Format yang didukung: jpeg, png, jpg, gif.</small>
            </div>

            <div class="mb-3">
                <img id="avatar-preview"
                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/compiled/jpg/1.jpg') }}"
                    alt="Avatar Preview" class="img-thumbnail" style="max-width: 150px;">
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="{{ Auth::user()->role == 'admin' ? route('dashboard') : route('presensi') }}" type="button"
                class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script>
        function previewAvatar(event) {
            const avatarPreview = document.getElementById('avatar-preview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                // Jika file dihapus atau tidak dipilih, kembali ke default
                avatarPreview.src =
                    "{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/compiled/jpg/1.jpg') }}";
            }
        }
    </script>
@endsection
