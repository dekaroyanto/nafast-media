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
            'norek' => 123456789,
            'bank' => 'BCA',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'status' => 'active',
            'jabatan_id' => 1,
        ]);

        User::create([
            'name' => 'Maryam',
            'norek' => 333333333,
            'bank' => 'BRI',
            'email' => 'maryam@gmail.com',
            'username' => 'maryam',
            'password' => Hash::make('karyawan'),
            'role' => 'karyawan',
            'status' => 'active',
            'jabatan_id' => 2,
        ]);

        User::create([
            'name' => 'Ansel',
            'norek' => 44444444,
            'bank' => 'BNI',
            'email' => 'ansel@gmail.com',
            'username' => 'ansel',
            'password' => Hash::make('karyawan'),
            'role' => 'karyawan',
            'status' => 'active',
            'jabatan_id' => 3,
        ]);
    }
}
