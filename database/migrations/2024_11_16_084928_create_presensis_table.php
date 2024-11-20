<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->timestamp('datang')->nullable();
            $table->timestamp('pulang')->nullable();
            $table->string('lama_jam_kerja')->nullable();
            $table->enum('status_kehadiran', ['hadir', 'izin', 'sakit', 'wfh', 'alfa'])->default('hadir');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('presensi');
    }
};
