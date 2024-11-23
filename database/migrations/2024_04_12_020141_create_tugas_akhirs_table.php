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
            $table->enum('status', ['draft', 'acc', 'reject', 'cancel', 'revisi']);
            $table->text('catatan')->nullable();
            $table->enum('status_seminar', ['revisi', 'acc', 'reject'])->nullable();
            $table->enum('status_sidang', ['revisi', 'acc', 'reject'])->nullable();
            $table->enum('status_pemberkasan', ['belum_lengkap', 'sudah_lengkap'])->default('belum_lengkap')->nullable();
            $table->boolean('is_completed')->nullable()->default(false);
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
