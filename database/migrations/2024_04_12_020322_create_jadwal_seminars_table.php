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
        Schema::create('jadwal_seminars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_akhir_id')->references('id')->on('tugas_akhirs')->onDelete('cascade');
            $table->foreignId('ruangan_id')->nullable()->references('id')->on('ruangans')->onDelete('cascade');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->date('tanggal')->nullable();
            $table->enum('status', ['belum_terjadwal','sudah_terjadwal','telah_seminar']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_seminars');
    }
};
