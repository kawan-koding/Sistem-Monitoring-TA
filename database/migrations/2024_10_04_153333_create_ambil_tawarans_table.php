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
        Schema::create('ambil_tawarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekomendasi_topik_id')->nullable()->references('id')->on('rekomendasi_topiks')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->nullable()->references('id')->on('mahasiswas')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->enum('status', ['Menunggu', 'Ditolak', 'Disetujui'])->default('Menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ambil_tawarans');
    }
};
