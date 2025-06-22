<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah role 'admin' sudah ada
        Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrator']
        );

        // Cek apakah role 'user' sudah ada
        Role::firstOrCreate(
            ['name' => 'user'],
            ['description' => 'Pengguna Biasa']
        );
    }
}
