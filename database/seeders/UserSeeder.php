<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::firstOrCreate(
            ['email' => 'sintia.admin@caremore.com'],
            [
                'name' => 'Admin Sintia CareMore',
                'password' => Hash::make('adminsintiacaremore'), // Ganti dengan password yang kuat di produksi
                'role_id' => 1,
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // Robby User
        User::firstOrCreate(
            ['email' => 'robbypasien@caremore.com'],
            [
                'name' => 'Robby Users',
                'password' => Hash::make('robbypasiencaremore'), // Ganti dengan password yang kuat di produksi
                'role_id' => 2,
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // Tambahan Users dari Factory
        User::factory()->count(10)->create();
    }
}
