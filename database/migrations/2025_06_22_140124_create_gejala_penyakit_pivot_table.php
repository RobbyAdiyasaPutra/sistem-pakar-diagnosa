<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gejala_penyakit', function (Blueprint $table) {
            // Foreign key to penyakits table
            $table->foreignId('penyakit_id')
                ->constrained('penyakits')  // References 'penyakits' table
                ->cascadeOnDelete();         // Delete pivot when disease is deleted
            
            // Foreign key to gejalas table
            $table->foreignId('gejala_id')
                ->constrained('gejalas')    // References 'gejalas' table
                ->cascadeOnDelete();         // Delete pivot when symptom is deleted
            
            // Composite primary key
            $table->primary(['penyakit_id', 'gejala_id']);
            
            // Optional: Timestamps if you need to track when relationships were created
            // $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gejala_penyakit');
    }
};