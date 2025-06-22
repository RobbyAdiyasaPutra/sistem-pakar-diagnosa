<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('image_url')->nullable();
            $table->string('tags')->nullable(); // Asumsi tags disimpan sebagai string koma-terpisah
            $table->timestamp('published_at')->nullable(); // Untuk menandai kapan artikel dipublikasikan
            $table->unsignedInteger('views_count')->default(0); // Untuk menghitung jumlah dilihat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};