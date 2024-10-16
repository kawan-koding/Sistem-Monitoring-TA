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
            $table->foreignId('jenis_ta_id')->references('id')->on('jenis_tas')->onDelete('cascade');
            $table->foreignId('topik_id')->references('id')->on('topiks')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->references('id')->on('mahasiswas')->onDelete('cascade');
            $table->foreignId('periode_ta_id')->references('id')->on('periode_tas')->onDelete('cascade');
            $table->text('judul');
            $table->enum('tipe', ['K', 'I']);
            $table->string('dokumen_pemb_1', 255)->nullable();
            $table->string('dokumen_ringkasan', 255);
            $table->string('file_proposal', 255)->nullable();
            $table->string('file_pengesahan', 255)->nullable();
            $table->string('file_draft', 255)->nullable();
            $table->enum('status', ['draft', 'acc', 'reject','cancel']);
            $table->text('catatan')->nullable();
            $table->enum('status_seminar', ['revisi', 'acc', 'reject'])->nullable();
            $table->boolean('is_completed')->nullable()->default(false);
            $table->string('file_persetujuan_pemb_2', 255)->nullable();
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
