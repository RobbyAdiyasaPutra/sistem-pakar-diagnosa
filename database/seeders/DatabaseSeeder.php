<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            GejalaSeeder::class,
            PenyakitSeeder::class,
            KasusSeeder::class,     // Membutuhkan Penyakit dan Gejala
            SolusiSeeder::class,    // Membutuhkan Penyakit
            ArticleSeeder::class,
            DiagnosaSeeder::class,
            GejalaPenyakitSeeder::class,  // Membutuhkan User, Penyakit, dan Gejala
        ]);
    }
}