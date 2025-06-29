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
        Schema::create('periode_tas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 200)->nullable();
            $table->date('mulai_daftar')->nullable();
            $table->date('akhir_daftar')->nullable();
            $table->date('mulai_seminar')->nullable();
            $table->date('akhir_seminar')->nullable();
            $table->date('mulai_sidang')->nullable();
            $table->date('akhir_sidang')->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreignId('program_studi_id')->nullable()->references('id')->on('program_studis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_tas');
    }
};
