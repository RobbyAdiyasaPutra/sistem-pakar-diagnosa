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
     * Accessor untuk mendapatkan detail objek Gejala dari gejala_terpilih.
     * Menggunakan ini akan memuat gejala secara efisien.
     */
        // Accessor untuk mendapatkan detail objek Gejala
    public function getGejalaTerpilihDetailAttribute()
    {
        if (!empty($this->gejala_terpilih) && is_array($this->gejala_terpilih)) {
            return \App\Models\Gejala::whereIn('id', $this->gejala_terpilih)->get();
        }
        return collect(); // Mengembalikan koleksi kosong jika tidak ada gejala
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Penyakit (opsional, jika diagnosa menghasilkan penyakit)
    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class);
    }
}