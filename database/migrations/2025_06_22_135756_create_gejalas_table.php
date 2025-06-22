<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gejalas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_gejala', 10)->unique();
            $table->string('nama_gejala');
            $table->string('kategori')->nullable(); // Ditambahkan berdasarkan DiagnosaController
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gejalas');
    }
};