<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Diagnosa;
use App\Models\User;
use App\Models\Penyakit;
use App\Models\Gejala;
use Illuminate\Support\Arr; // Untuk fungsi array random

class DiagnosaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $penyakits = Penyakit::all();
        $gejalas = Gejala::all();

        if ($users->isEmpty() || $penyakits->isEmpty() || $gejalas->isEmpty()) {
            $this->command->warn('Skipping DiagnosaSeeder: Users, Penyakits, or Gejalas not found. Please run their seeders first.');
            return;
        }

        foreach ($users as $user) {
            // Buat 1-3 diagnosa untuk setiap user
            for ($i = 0; $i < rand(1, 3); $i++) {
                $penyakit = $penyakits->random();
                $numGejala = rand(3, 7); // Jumlah gejala yang dipilih
                $selectedGejalaIds = $gejalas->random($numGejala)->pluck('id')->toArray();

                $metadataGejala = [];
                foreach ($selectedGejalaIds as $gejalaId) {
                    $metadataGejala[$gejalaId] = rand(1, 5); // Tingkat keparahan random
                }

                Diagnosa::create([
                    'user_id' => $user->id,
                    'penyakit_id' => $penyakit->id,
                    'gejala_terpilih' => json_encode($selectedGejalaIds), // Simpan sebagai JSON string
                    'similarity_score' => round(rand(60, 95) / 100, 2), // Contoh skor
                    'cf_value' => round(rand(0, 100) / 100, 2), // Contoh CF value
                    'hasil_diagnosa' => $penyakit->nama_penyakit,
                    'rekomendasi' => 'Rekomendasi umum untuk ' . $penyakit->nama_penyakit . '. Kunjungi profesional untuk penanganan lebih lanjut.',
                    'metadata' => json_encode(['tingkat_keparahan' => $metadataGejala]), // Simpan metadata sebagai JSON
                    'created_at' => now()->subDays(rand(1, 60)), // Tanggal acak dalam 60 hari terakhir
                    'updated_at' => now()->subDays(rand(1, 60)),
                ]);
            }
        }
    }
}