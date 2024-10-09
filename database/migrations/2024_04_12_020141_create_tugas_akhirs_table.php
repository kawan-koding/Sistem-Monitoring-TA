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
        Schema::create('tugas_akhirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_ta_id');
            $table->unsignedBigInteger('topik_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('periode_ta_id');
            $table->foreign('jenis_ta_id')->references('id')->on('jenis_tas')->onDelete('cascade');
            $table->foreign('topik_id')->references('id')->on('topiks')->onDelete('cascade');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->onDelete('cascade');
            $table->foreign('periode_ta_id')->references('id')->on('periode_tas')->onDelete('cascade');
            $table->string('judul', 255);
            $table->enum('tipe', ['K', 'I']);
            $table->string('dokumen_pemb_1', 255)->nullable();
            $table->string('dokumen_ringkasan', 255);
            $table->string('file_proposal', 255)->nullable();
            $table->string('file_pengesahan', 255)->nullable();
            $table->string('file_draft', 255)->nullable();
            $table->enum('status', ['draft', 'acc', 'reject']);
            $table->text('catatan')->nullable();
            $table->enum('status_seminar', ['revisi', 'acc', 'reject'])->nullable();
            // $table->string('periode_mulai', 45);
            // $table->string('periode_akhir', 45);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_akhirs');
    }
};
