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
        Schema::create('kuota_dosens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->nullable()->references('id')->on('dosens')->onDelete('restrict');
            $table->foreignId('periode_ta_id')->nullable()->references('id')->on('periode_tas')->onDelete('restrict');
            $table->foreignId('program_studi_id')->nullable()->references('id')->on('program_studis')->onDelete('restrict');
            $table->integer('pembimbing_1')->default(0);
            $table->integer('pembimbing_2')->default(0);
            $table->integer('penguji_1')->default(0);
            $table->integer('penguji_2')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuota_dosens');
    }
};
