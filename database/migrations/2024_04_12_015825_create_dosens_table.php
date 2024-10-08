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
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable();
            $table->string('nidn')->nullable();
            $table->string('name')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('email')->nullable();
            $table->string('telp')->nullable();
            $table->text('alamat')->nullable();
            $table->text('ttd')->nullable();    
            $table->string('bidang_keahlian')->nullable();
            $table->foreignId('program_studi_id')->nullable()->references('id')->on('program_studis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
