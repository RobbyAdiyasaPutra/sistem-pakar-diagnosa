<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Solusi extends Model
{
    use HasFactory;

    protected $fillable = [
        'penyakit_id',
        'solusi',
        'tingkat_keparahan',
        'langkah_langkah',
    ];

    /**
     * Get the penyakit that owns the solusi.
     */
    public function penyakit(): BelongsTo
    {
        return $this->belongsTo(Penyakit::class);
    }
}