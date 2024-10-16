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
        Schema::create('bimbing_ujis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tugas_akhir_id');
            $table->unsignedBigInteger('dosen_id');
            $table->foreign('tugas_akhir_id')->references('id')->on('tugas_akhirs')->onDelete('cascade');
            $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade');
            $table->enum('jenis', ['penguji', 'pembimbing', 'pengganti']);
            $table->integer('urut');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbing_ujis');
    }
};
