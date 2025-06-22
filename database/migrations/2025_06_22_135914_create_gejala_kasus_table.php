<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gejala_kasus', function (Blueprint $table) {
            // Foreign keys
            $table->foreignId('kasus_id')->constrained('kasus')->onDelete('cascade'); // Merujuk ke tabel 'kasus'
            $table->foreignId('gejala_id')->constrained('gejalas')->onDelete('cascade');

            // Kolom tambahan di tabel pivot
            $table->integer('tingkat_keparahan_gejala')->default(1); // Default value 1 seperti di DiagnosaController

            // Composite Primary Key (kunci utama gabungan)
            $table->primary(['kasus_id', 'gejala_id']);

            // Timestamps (opsional untuk tabel pivot, tapi disertakan jika Anda memerlukannya)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gejala_kasus');
    }
};