<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str; // Tambahkan ini jika menggunakan slug secara otomatis

class Penyakit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_penyakit',
        'nama_penyakit',
        'slug', // Tambahkan slug
        'deskripsi',
        'solusi_umum',
    ];

    /**
     * The "booted" method of the model.
     * Digunakan untuk otomatis membuat slug saat disimpan.
     */
    protected static function booted(): void
    {
        static::creating(function (Penyakit $penyakit) {
            $penyakit->slug = Str::slug($penyakit->nama_penyakit);
        });

        static::updating(function (Penyakit $penyakit) {
            if ($penyakit->isDirty('nama_penyakit')) {
                $penyakit->slug = Str::slug($penyakit->nama_penyakit);
            }
        });
    }
 // Add inverse relationship
    public function gejalas()
    {
    // Pastikan menggunakan withPivot('cf_value')
    return $this->belongsToMany(Gejala::class, 'gejala_penyakit')->withPivot('cf_value');
    }
    
    /**
     * Get the solusis for the penyakit.
     */
    // app/Models/Penyakit.php
// app/Models/Penyakit.php
    public function solusi()
    {
        return $this->hasOne(Solusi::class); // Atau hasMany jika satu penyakit bisa punya banyak solusi
    }

    /**
     * Get the kasus for the penyakit.
     */
    public function kasus(): HasMany
    {
        return $this->hasMany(Kasus::class);
    }

    /**
     * Get the diagnosas for the penyakit.
     */
    public function diagnosas(): HasMany
    {
        return $this->hasMany(Diagnosa::class);
    }
    
}