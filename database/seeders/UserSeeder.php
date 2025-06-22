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
        User::create([
            'name' => 'Admin Sintia CareMore',
            'email' => 'sintia.admin@caremore.com',
            'password' => Hash::make('adminsintiacaremore'), // Ganti dengan password yang kuat di produksi
            'usertype' => 'admin',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Robby Users',
            'email' => 'robbypasien@caremore.com',
            'password' => Hash::make('robbypasiencaremore'), // Ganti dengan password yang kuat di produksi
            'usertype' => 'admin',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        // Regular Users
        User::factory()->count(10)->create(); // Menggunakan factory untuk 10 user biasa
    }
}