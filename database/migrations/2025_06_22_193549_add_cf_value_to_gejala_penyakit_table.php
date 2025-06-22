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
        Schema::table('gejala_penyakit', function (Blueprint $table) {
            // Tambahkan kolom untuk nilai Certainty Factor (tipe float/double)
            // Default 0 jika tidak diset, atau bisa nullable
            $table->float('cf_value')->default(0)->after('gejala_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gejala_penyakit', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $table->dropColumn('cf_value');
        });
    }
};