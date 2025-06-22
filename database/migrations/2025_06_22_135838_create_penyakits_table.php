<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyakits', function (Blueprint $table) {
            $table->id();
            $table->string('kode_penyakit', 10)->unique();
            $table->string('nama_penyakit');
            $table->string('slug')->unique(); // Dari PenyakitController
            $table->text('deskripsi')->nullable();
            $table->text('penanganan_umum')->nullable(); // Dari PenyakitController
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyakits');
    }
};