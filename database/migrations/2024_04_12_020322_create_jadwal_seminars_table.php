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
            $table->unsignedBigInteger('tugas_akhir_id');
            $table->unsignedBigInteger('ruangan_id');
            $table->unsignedBigInteger('hari_id');
            $table->foreign('tugas_akhir_id')->references('id')->on('tugas_akhirs')->onDelete('cascade');
            $table->foreign('ruangan_id')->references('id')->on('ruangans')->onDelete('cascade');
            $table->foreign('hari_id')->references('id')->on('haris')->onDelete('cascade');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->date('tanggal');
            $table->tinyInteger('status');
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