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
        Schema::create('jabatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan');
            $table->bigInteger('gajipokok');
            $table->bigInteger('tunjangan_jabatan')->default(0);      // Kolom baru
            $table->bigInteger('tunjangan_kesehatan')->default(0);    // Kolom baru
            $table->bigInteger('tunjangan_transportasi')->default(0); // Kolom baru
            $table->bigInteger('tunjangan_makan')->default(0);        // Kolom baru
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatans');
    }
};
