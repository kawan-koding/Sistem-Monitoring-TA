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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bimbing_uji_id')->nullable()->references('id')->on('bimbing_ujis')->onDelete('cascade');
            $table->foreignId('kategori_nilai_id')->nullable()->references('id')->on('kategori_nilais')->onDelete('cascade');
            $table->string('nilai');
            $table->enum('type',['Seminar','Sidang']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
