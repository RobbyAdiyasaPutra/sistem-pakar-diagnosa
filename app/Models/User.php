<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Pastikan ini ada jika Anda menggunakan role_id
        'is_active', // Pastikan ini ada jika Anda menggunakan is_active
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean', // Penting jika is_active adalah boolean
    ];

    // Relasi ke model Role jika ada
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Cek apakah user adalah admin.
     * Ini adalah metode penting yang digunakan oleh AdminMiddleware.
     * Anda perlu menyesuaikan logika ini berdasarkan bagaimana Anda mendefinisikan "admin" di aplikasi Anda.
     * Contoh:
     * - Berdasarkan nama role ('admin')
     * - Berdasarkan role_id tertentu (misal: role_id == 1)
     * - Berdasarkan kolom boolean 'is_admin' di tabel users
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        // Example: If 'admin' is a role name in your 'roles' table
        return $this->role && $this->role->name === 'admin';
        // Or if you have a specific role_id for admin, e.g., return $this->role_id === 1;
    }

    public function isUser(): bool
    {
        // A simple way to define a regular user if they are not an admin
        return !$this->isAdmin();
    }
}