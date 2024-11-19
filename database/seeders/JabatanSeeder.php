<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatans = [
            ['nama_jabatan' => 'Manager', 'gajipokok' => 15000000],
            ['nama_jabatan' => 'Supervisor', 'gajipokok' => 10000000],
            ['nama_jabatan' => 'Staff', 'gajipokok' => 7000000],
            ['nama_jabatan' => 'Operator', 'gajipokok' => 5000000],
        ];

        DB::table('jabatans')->insert($jabatans);
    }
}
