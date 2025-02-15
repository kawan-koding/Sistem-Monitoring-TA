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
        Schema::create('revisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bimbing_uji_id')->nullable()->references('id')->on('bimbing_ujis')->onDelete('cascade');
            $table->enum('type',['Seminar','Sidang']);
            $table->text('catatan')->nullable();
            $table->boolean('is_valid')->default(false);
            $table->boolean('is_mentor_validation')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revisis');
    }
};
