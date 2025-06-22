<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams; // Keep HasTeams if you are using Jetstream's team features
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    // Make sure HasTeams is present if your application utilizes it
    // If not, you can remove it. For this example, I'll keep it as per your original file structure.
    use HasTeams;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // <--- IMPORTANT: Add 'role_id' here if you're using it to manage roles
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user has an 'admin' role.
     * Adjust the logic based on how you store user roles (e.g., 'role_id' column, or a 'roles' relationship).
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        // Option 1: If you have a 'role_id' column in your users table (recommended for simplicity)
        // Assuming '1' is the ID for the 'admin' role.
        return $this->role_id === 1;

        // Option 2: If you have a 'name' column in your 'roles' table and a 'role_id' foreign key in 'users'
        // return $this->role && $this->role->name === 'admin';

        // Option 3: If you have a many-to-many relationship with a 'roles' table
        // return $this->roles->contains('name', 'admin');
    }

    /**
     * Check if the user has a 'regular user' role.
     * Adjust the logic based on how you store user roles.
     *
     * @return bool
     */
    public function isUser(): bool
    {
        // Option 1: If you have a 'role_id' column in your users table
        // Assuming '2' is the ID for a 'regular user' role.
        return $this->role_id === 2;

        // Option 2: If you have a 'name' column in your 'roles' table
        // return $this->role && $this->role->name === 'user';

        // Option 3: If you have a many-to-many relationship with a 'roles' table
        // return $this->roles->contains('name', 'user');
    }

    /**
     * Define the relationship to the Role model.
     * Uncomment and use this method if you have a 'roles' table and a 'role_id' foreign key.
     * Make sure you have a `Role.php` model in `app/Models/Role.php`.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}