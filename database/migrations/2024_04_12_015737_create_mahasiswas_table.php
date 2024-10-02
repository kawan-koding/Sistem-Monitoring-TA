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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('kelas')->nullable();
            $table->string('nim')->nullable();
            $table->string('nama_mhs')->nullable();
            $table->enum('jenis_kelamin', ['Perempuan', 'Laki-laki', 'Lainnya'])->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('telp')->nullable();
            $table->foreignId('program_studi_id')->nullable()->references('id')->on('program_studis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
