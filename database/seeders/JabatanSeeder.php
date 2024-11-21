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
            [
                'nama_jabatan' => 'Admin',
                'gajipokok' => 0,
                'tunjangan_jabatan' => 0,
                'tunjangan_kesehatan' => 0,
                'tunjangan_transportasi' => 0,
                'tunjangan_makan' => 0,
            ],
            [
                'nama_jabatan' => 'CS',
                'gajipokok' => 1270000,
                'tunjangan_jabatan' => 0,
                'tunjangan_kesehatan' => 150000,
                'tunjangan_transportasi' => 20000,
                'tunjangan_makan' => 20000,
            ],
            [
                'nama_jabatan' => 'Creative',
                'gajipokok' => 1500000,
                'tunjangan_jabatan' => 0,
                'tunjangan_kesehatan' => 150000,
                'tunjangan_transportasi' => 20000,
                'tunjangan_makan' => 20000,
            ],
        ];

        DB::table('jabatans')->insert($jabatans);
    }
}
