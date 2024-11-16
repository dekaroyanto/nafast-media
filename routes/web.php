<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarisController;

Route::get('/', function () {
    return view('auth.login');
})->name('home');

// Route::get('/home', [HomeController::class, 'home'])->name('home');


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });

// Route::middleware(['auth', 'role:karyawan'])->group(function () {
//     Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
// });


Route::middleware(['auth', 'role:admin', 'check.ip'])->group(function () {
    Route::get('/menu', [DashboardController::class, 'menu'])->name('menu');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan');
    Route::get('/jabatan/tambah', [JabatanController::class, 'create'])->name('jabatan.create');
    Route::post('/jabatan/store', [JabatanController::class, 'store'])->name('jabatan.store');
    Route::get('/jabatan/edit', [JabatanController::class, 'edit'])->name('jabatan.edit');
    Route::post('/jabatan/update', [JabatanController::class, 'update'])->name('jabatan.update');
    Route::delete('/jabatan/{id}', [JabatanController::class, 'destroy'])->name('jabatan.destroy');



    Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris');
});

// Hanya karyawan yang bisa akses absensi
Route::middleware(['auth', 'role:karyawan', 'check.ip'])->group(function () {
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi');
    Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');
});

// Route::get('/check-ip', function (Request $request) {
//     return $request->ip();
// });
