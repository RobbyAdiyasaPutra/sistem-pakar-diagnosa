<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnosas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('penyakit_id')->nullable()->constrained('penyakits')->onDelete('set null'); // Bisa null jika tidak ada hasil cocok
            $table->json('gejala_terpilih'); // Menyimpan ID gejala yang dipilih (array JSON)
            $table->float('similarity_score')->nullable();
            $table->float('cf_value')->nullable(); // Certainty Factor
            $table->string('hasil_diagnosa')->nullable(); // Nama penyakit hasil diagnosa
            $table->text('rekomendasi')->nullable(); // Solusi/rekomendasi dari diagnosa
            $table->json('metadata')->nullable(); // Untuk menyimpan tingkat keparahan gejala terpilih
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosas');
    }
};