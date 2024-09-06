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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('kelas', 45);
            $table->string('nim', 45);
            $table->string('nama_mhs', 45);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('email', 45)->nullable();
            $table->string('telp', 45);
            // $table->string('tempat_lahir', 45);
            // $table->date('tanggal_lahir');
            // $table->string('alamat', 200);
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
