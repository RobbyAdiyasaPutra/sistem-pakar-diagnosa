<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasTeams;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Pastikan ini ada jika Anda menggunakan kolom role_id
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user has an 'admin' role.
     */
    public function isAdmin(): bool
    {
        return $this->role_id === 1; // Sesuaikan dengan ID role admin di DB Anda
    }

    /**
     * Check if the user has a 'regular user' role.
     */
    public function isUser(): bool
    {
        return $this->role_id === 2; // Sesuaikan dengan ID role user biasa di DB Anda
    }

    /**
     * Define the relationship to the Role model.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}