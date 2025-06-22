<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection; // Untuk mengelola array gejala_terpilih sebagai Collection

class Diagnosa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'penyakit_id',
        'gejala_terpilih', // Akan di-cast sebagai array/JSON
        'similarity_score',
        'cf_value',
        'hasil_diagnosa',
        'rekomendasi',
        'metadata', // Akan di-cast sebagai array/JSON
    ];

    protected $casts = [
        'gejala_terpilih' => 'array', // Menyimpan ID gejala sebagai JSON array
        'metadata' => 'array', // Untuk menyimpan data tambahan sebagai JSON
        // 'created_at' dan 'updated_at' otomatis di-cast oleh Laravel
    ];

    /**
     * Get the user that owns the diagnosa.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the penyakit that was diagnosed.
     */
    public function penyakit(): BelongsTo
    {
        return $this->belongsTo(Penyakit::class);
    }

    /**
     * Accessor untuk mendapatkan detail objek Gejala dari gejala_terpilih.
     * Menggunakan ini akan memuat gejala secara efisien.
     */
    public function getGejalaTerpilihDetailAttribute(): Collection
    {
        // Memuat semua gejala yang ID-nya ada di `gejala_terpilih`
        // dan mengembalikan sebagai Collection objek Gejala
        return Gejala::whereIn('id', $this->gejala_terpilih ?? [])->get();
    }
}