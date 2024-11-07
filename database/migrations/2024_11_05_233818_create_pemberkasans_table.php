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
        Schema::create('pemberkasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_akhir_id')->nullable()->references('id')->on('tugas_akhirs')->onDelete('cascade');
            $table->foreignId('jenis_dokumen_id')->nullable()->references('id')->on('jenis_dokumens')->onDelete('cascade');
            $table->text('filename');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemberkasans');
    }
};
