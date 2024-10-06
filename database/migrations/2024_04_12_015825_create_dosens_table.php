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
            $table->string('nip', 45);
            $table->string('nidn', 45);
            $table->string('name', 45);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('email', 45)->nullable();
            $table->string('telp', 45)->nullable();
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
