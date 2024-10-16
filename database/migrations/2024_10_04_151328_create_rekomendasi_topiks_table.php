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
            $table->enum('tipe',['Kelompok','Individu']);
            $table->bigInteger('kuota');
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
