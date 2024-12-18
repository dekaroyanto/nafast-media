<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gaji_karyawans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('jabatan_id');
            $table->unsignedBigInteger('created_by');
            $table->date('tanggal_gaji');
            $table->integer('jumlah_hadir');
            $table->integer('jumlah_izin')->default(0);
            $table->integer('jumlah_sakit')->default(0);
            $table->integer('jumlah_wfh')->default(0);
            $table->integer('jumlah_alfa')->default(0);
            $table->integer('jumlah_hari_kerja');
            $table->bigInteger('gaji_pokok');
            $table->decimal('gaji_per_hari', 15, 2);
            $table->decimal('gaji_per_hari_didapat', 15, 2); // Kolom baru
            $table->decimal('tunjangan_transport_didapat', 15, 2); // Kolom baru
            $table->decimal('tunjangan_makan_didapat', 15, 2); // Kolom baru
            $table->bigInteger('tunjangan_kesehatan')->default(0);
            $table->bigInteger('tunjangan_jabatan')->default(0);
            $table->bigInteger('bonus')->default(0);
            $table->bigInteger('potongan')->default(0);
            $table->bigInteger('total_gaji');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jabatan_id')->references('id')->on('jabatans')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_karyawans');
    }
};
