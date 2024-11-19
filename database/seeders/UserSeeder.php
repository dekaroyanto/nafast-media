<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'jabatan_id' => 2,
        ]);

        User::create([
            'name' => 'Karyawan',
            'email' => 'karyawan@gmail.com',
            'username' => 'karyawan',
            'password' => Hash::make('karyawan'),
            'role' => 'karyawan',
            'jabatan_id' => 1,
        ]);

        User::create([
            'name' => 'Karyawan Dua',
            'email' => 'karyawan2@gmail.com',
            'username' => 'karyawan2',
            'password' => Hash::make('karyawan2'),
            'role' => 'karyawan',
            'jabatan_id' => 3,
        ]);
    }
}
