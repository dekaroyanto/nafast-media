<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\GajiKaryawanController;
use App\Http\Controllers\LaporanKaryawanController;

Route::get('/', function () {
    return view('auth.login');
})->name('home');


Route::get('/register', [AuthController::class, 'registerform'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'role:admin', 'check.ip'])->group(function () {
    Route::get('/menu', [DashboardController::class, 'menu'])->name('menu');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan');
    Route::get('/jabatan/tambah', [JabatanController::class, 'create'])->name('jabatan.create');
    Route::post('/jabatan/store', [JabatanController::class, 'store'])->name('jabatan.store');
    Route::get('/jabatan/{id}/edit', [JabatanController::class, 'edit'])->name('jabatan.edit');
    Route::put('/jabatan/{id}', [JabatanController::class, 'update'])->name('jabatan.update');
    Route::delete('/jabatan/{id}', [JabatanController::class, 'destroy'])->name('jabatan.destroy');

    Route::get('/presensikaryawan', [PresensiController::class, 'indexadmin'])->name('presensikaryawan');
    Route::get('/presensi/admin/create', [PresensiController::class, 'createByAdmin'])->name('admin.presensi.create');
    Route::post('/presensi/admin/store', [PresensiController::class, 'storeByAdmin'])->name('admin.presensi.store');
    Route::get('/presensi/{id}/edit', [PresensiController::class, 'edit'])->name('admin.presensi.edit');
    Route::put('/presensi/{id}', [PresensiController::class, 'update'])->name('admin.presensi.update');
    Route::delete('/presensi/{id}', [PresensiController::class, 'destroy'])->name('admin.presensi.destroy');


    Route::get('gaji', [GajiKaryawanController::class, 'index'])->name('gaji.index');
    Route::get('/gaji/tambah', [GajiKaryawanController::class, 'create'])->name('gaji.create');
    Route::post('/gaji/store', [GajiKaryawanController::class, 'store'])->name('gaji.store');
    Route::get('/jumlah-presensi/{user_id}/{year}/{month}', [GajiKaryawanController::class, 'fetchJumlahPresensi']);
    Route::get('/gaji/{id}/edit', [GajiKaryawanController::class, 'edit'])->name('gaji.edit');
    Route::put('/gaji/{id}', [GajiKaryawanController::class, 'update'])->name('gaji.update');
    Route::delete('/gaji/{id}', [GajiKaryawanController::class, 'destroy'])->name('gaji.destroy');

    Route::get('/gaji/print', [GajiKaryawanController::class, 'printAll'])->name('gaji.printAll');

    Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris');
});

// Hanya karyawan yang bisa akses absensi
Route::middleware(['auth', 'role:karyawan', 'check.ip'])->group(function () {
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi');
    Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');

    Route::get('/gaji/my', [GajiKaryawanController::class, 'myGaji'])->name('gaji.my');

    Route::get('/gaji/print/my', [GajiKaryawanController::class, 'printMine'])->name('gaji.printMine');
});

Route::middleware(['auth', 'check.ip'])->group(function () {
    Route::get('/profile', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::get('/profile/change-password', [AuthController::class, 'editPassword'])->name('profile.editPassword');
    Route::post('/profile/change-password', [AuthController::class, 'updatePassword'])->name('profile.updatePassword');

    Route::get('/laporan', [LaporanKaryawanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/create', [LaporanKaryawanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [LaporanKaryawanController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{id}/edit', [LaporanKaryawanController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{id}', [LaporanKaryawanController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{id}', [LaporanKaryawanController::class, 'destroy'])->name('laporan.destroy');
});
