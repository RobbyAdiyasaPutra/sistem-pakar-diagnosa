<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solusis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyakit_id')->constrained('penyakits')->onDelete('cascade');
            $table->text('solusi');
            $table->integer('tingkat_keparahan')->nullable(); // Dari SolusiController
            $table->text('langkah_langkah')->nullable(); // Dari SolusiController
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solusis');
    }
};