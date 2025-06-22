<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kasus;
use App\Models\Penyakit;
use App\Models\Gejala;

class KasusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $depresi = Penyakit::where('kode_penyakit', 'P01')->first();
        $gad = Penyakit::where('kode_penyakit', 'P02')->first();
        $panik = Penyakit::where('kode_penyakit', 'P03')->first();
        $stres = Penyakit::where('kode_penyakit', 'P04')->first();

        // Ambil beberapa gejala yang relevan
        $g1 = Gejala::where('kode_gejala', 'G01')->first(); // Sulit tidur
        $g2 = Gejala::where('kode_gejala', 'G02')->first(); // Kelelahan
        $g3 = Gejala::where('kode_gejala', 'G08')->first(); // Mudah tersinggung
        $g4 = Gejala::where('kode_gejala', 'G09')->first(); // Kesulitan konsentrasi
        $g5 = Gejala::where('kode_gejala', 'G10')->first(); // Perasaan sedih
        $g6 = Gejala::where('kode_gejala', 'G11')->first(); // Kehilangan minat
        $g7 = Gejala::where('kode_gejala', 'G14')->first(); // Kecemasan berlebihan
        $g8 = Gejala::where('kode_gejala', 'G05')->first(); // Detak jantung cepat
        $g9 = Gejala::where('kode_gejala', 'G07')->first(); // Gelisah

        if ($depresi && $gad && $panik && $stres && $g1 && $g2 && $g3 && $g4 && $g5 && $g6 && $g7 && $g8 && $g9) {
            // Kasus 1: Depresi ringan
            $kasus1 = Kasus::create([
                'penyakit_id' => $depresi->id,
                'solusi' => 'Menghadiri sesi terapi kognitif perilaku dan meningkatkan aktivitas fisik ringan.',
                'keterangan' => 'Pasien merasakan gejala depresi ringan yang berlangsung selama beberapa minggu.'
            ]);
            $kasus1->gejalas()->attach([
                $g1->id => ['tingkat_keparahan_gejala' => 2],
                $g2->id => ['tingkat_keparahan_gejala' => 3],
                $g5->id => ['tingkat_keparahan_gejala' => 2],
                $g6->id => ['tingkat_keparahan_gejala' => 2],
            ]);

            // Kasus 2: GAD sedang
            $kasus2 = Kasus::create([
                'penyakit_id' => $gad->id,
                'solusi' => 'Latihan pernapasan dalam dan konsultasi rutin dengan psikolog.',
                'keterangan' => 'Kecemasan yang sering dan mengganggu aktivitas sehari-hari.'
            ]);
            $kasus2->gejalas()->attach([
                $g7->id => ['tingkat_keparahan_gejala' => 4],
                $g4->id => ['tingkat_keparahan_gejala' => 3],
                $g3->id => ['tingkat_keparahan_gejala' => 2],
                $g9->id => ['tingkat_keparahan_gejala' => 3],
            ]);

            // Kasus 3: Serangan Panik
            $kasus3 = Kasus::create([
                'penyakit_id' => $panik->id,
                'solusi' => 'Terapi eksposur dan manajemen stres.',
                'keterangan' => 'Mengalami serangan panik mendadak dengan gejala fisik yang parah.'
            ]);
            $kasus3->gejalas()->attach([
                $g8->id => ['tingkat_keparahan_gejala' => 5],
                $g7->id => ['tingkat_keparahan_gejala' => 5],
                $g6->id => ['tingkat_keparahan_gejala' => 3],
                $g3->id => ['tingkat_keparahan_gejala' => 4],
            ]);

            // Kasus 4: Stres Kronis
            $kasus4 = Kasus::create([
                'penyakit_id' => $stres->id,
                'solusi' => 'Menerapkan teknik relaksasi progresif dan mengatur jadwal istirahat.',
                'keterangan' => 'Tekanan pekerjaan yang berkelanjutan menyebabkan gejala stres.'
            ]);
            $kasus4->gejalas()->attach([
                $g1->id => ['tingkat_keparahan_gejala' => 3],
                $g2->id => ['tingkat_keparahan_gejala' => 4],
                $g4->id => ['tingkat_keparahan_gejala' => 3],
                $g3->id => ['tingkat_keparahan_gejala' => 3],
            ]);

            // Tambahkan kasus lainnya jika diperlukan
        } else {
            $this->command->warn('Skipping KasusSeeder: One or more required Gejala or Penyakit not found.');
        }
    }
}