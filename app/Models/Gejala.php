<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Gejala extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_gejala',
        'nama_gejala',
        'kategori'
    ];

    /**
     * The kasus that belong to the gejala.
     */
    public function kasus(): BelongsToMany
    {
        return $this->belongsToMany(Kasus::class, 'gejala_kasus')
                    ->withPivot('tingkat_keparahan_gejala'); // Jika ada kolom tambahan di pivot
    }

    /**
     * The penyakits that belong to the gejala.
     */
    public function penyakits(): BelongsToMany // Tambahkan tipe BelongsToMany untuk kejelasan
    {
        return $this->belongsToMany(Penyakit::class);
        // Laravel akan menebak nama tabel pivot sebagai 'gejala_penyakit'
        // dan foreign keys sebagai 'gejala_id' dan 'penyakit_id'.
    }
}