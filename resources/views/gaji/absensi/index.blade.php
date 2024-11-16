@extends('layouts.template')

@section('title', 'Absensi')

@section('content')

    <div class="card">
        <div class="card-header">
            <h1>Halaman Absensi</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>




@endsection
