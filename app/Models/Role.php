<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * Nama tabel jika berbeda dari default 'roles'
     */
    protected $table = 'roles';

    /**
     * Atribut yang bisa diisi secara massal.
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Relasi: satu role bisa dimiliki oleh banyak user.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
