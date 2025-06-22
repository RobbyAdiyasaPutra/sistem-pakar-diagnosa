<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kasus', function (Blueprint $table) { // Pastikan ini 'kasus' (tunggal)
            $table->id();
            // foreignId to 'penyakits' table
            $table->foreignId('penyakit_id')->constrained('penyakits')->onDelete('cascade');
            $table->text('solusi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kasus'); // Pastikan ini 'kasus' (tunggal)
    }
};