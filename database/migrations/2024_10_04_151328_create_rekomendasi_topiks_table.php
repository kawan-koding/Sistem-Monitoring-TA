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
        Schema::create('rekomendasi_topiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->nullable()->references('id')->on('dosens')->onDelete('cascade');
            $table->foreignId('jenis_ta_id')->nullable()->references('id')->on('jenis_tas')->onDelete('cascade');
            $table->text('judul');
            $table->text('deskripsi');
            $table->enum('status',['Menunggu','Ditolak','Disetujui']);
            $table->text('catatan')->nullable();
            $table->enum('tipe',['Kelompok','Individu']);
            $table->bigInteger('kuota');
            $table->foreignId('program_studi_id')->nullable()->references('id')->on('program_studis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penawaran_topiks');
    }
};
