<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasus extends Model
{
    use HasFactory;

    // Tambahkan baris ini jika nama tabel Anda adalah 'kasus' (tunggal)
    protected $table = 'kasus';

    protected $fillable = [
        'penyakit_id',
        'solusi',
        'keterangan'
    ];

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class);
    }

    public function gejalas()
    {
        return $this->belongsToMany(Gejala::class, 'gejala_kasus', 'kasus_id', 'gejala_id')
                    ->withPivot('tingkat_keparahan_gejala');
    }
}