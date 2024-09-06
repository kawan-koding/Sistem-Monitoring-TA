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
        Schema::create('uraian_revisis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('revisi_id');
            $table->foreign('revisi_id')->references('id')->on('revisis')->onDelete('cascade');
            $table->text('uraian')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uraian_revisis');
    }
};
