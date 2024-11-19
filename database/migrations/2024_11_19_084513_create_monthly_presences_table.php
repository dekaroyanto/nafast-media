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
        Schema::create('monthly_presences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('month'); // Bulan dalam format numerik, misal: 1 untuk Januari, 2 untuk Februari, dst.
            $table->integer('year'); // Tahun dalam format numerik, misal: 2024
            $table->integer('jumlah_hadir')->default(0); // Jumlah kehadiran per bulan
            $table->timestamps();

            // Foreign key relationship
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Unique constraint untuk memastikan tidak ada duplikasi data user per bulan dan tahun
            $table->unique(['user_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_presences');
    }
};
