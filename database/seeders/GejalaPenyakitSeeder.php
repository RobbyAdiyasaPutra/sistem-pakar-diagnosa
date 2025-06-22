<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Gunakan Facade DB
use App\Models\Gejala;
use App\Models\Penyakit;

class GejalaPenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Penting: Kosongkan tabel pivot terlebih dahulu agar tidak ada duplikasi jika seeder dijalankan berulang
        DB::table('gejala_penyakit')->truncate();

        // Ambil ID gejala dan penyakit, karena ID auto-increment bisa berubah
        // Lebih baik cari berdasarkan kode_gejala atau nama_penyakit untuk keandalan
        $gejalas = Gejala::pluck('id', 'kode_gejala');
        $penyakits = Penyakit::pluck('id', 'kode_penyakit');

        // Definisi hubungan gejala dan penyakit dan tambahkan nilai CF di sini
        $gejalaPenyakitData = [
            // Depresi (P01)
            [
                'penyakit_kode' => 'P01',
                'gejala_kodes_cf' => [
                    'G01' => 0.7, // Sulit tidur (Depresi)
                    'G02' => 0.8, // Kelelahan (Depresi)
                    'G03' => 0.6, // Perubahan nafsu makan (Depresi)
                    'G09' => 0.5, // Kesulitan konsentrasi (Depresi)
                    'G10' => 0.9, // Perasaan sedih (Depresi)
                    'G11' => 0.85, // Kehilangan minat (Depresi)
                    'G12' => 0.95, // Pikiran bunuh diri (Depresi) - nilai tinggi karena krusial
                    'G13' => 0.7, // Penarikan diri (Depresi)
                    'G15' => 0.65, // Perasaan tidak berharga (Depresi)
                    'G17' => 0.55, // Sulit mengambil keputusan (Depresi)
                ]
            ],
            // Gangguan Kecemasan Umum (GAD) (P02)
            [
                'penyakit_kode' => 'P02',
                'gejala_kodes_cf' => [
                    'G05' => 0.6, // Detak jantung cepat (GAD)
                    'G06' => 0.5, // Berkeringat berlebihan (GAD)
                    'G07' => 0.7, // Gelisah (GAD)
                    'G08' => 0.65, // Mudah tersinggung (GAD)
                    'G09' => 0.55, // Kesulitan konsentrasi (GAD)
                    'G14' => 0.85, // Kecemasan berlebihan (GAD)
                    'G18' => 0.9, // Cemas setiap saat (GAD)
                    'G17' => 0.4, // Sulit mengambil keputusan (GAD)
                ]
            ],
            // Gangguan Panik (P03)
            [
                'penyakit_kode' => 'P03',
                'gejala_kodes_cf' => [
                    'G05' => 0.9, // Detak jantung cepat (Panik) - sangat relevan
                    'G06' => 0.8, // Berkeringat berlebihan (Panik)
                    'G07' => 0.75, // Gelisah (Panik)
                    'G14' => 0.95, // Kecemasan berlebihan / Panik (Panik) - sangat relevan
                    'G04' => 0.6, // Sakit kepala / nyeri tubuh (Panik)
                    'G01' => 0.5, // Sulit tidur (Panik)
                    'G02' => 0.55, // Kelelahan (Panik)
                    'G10' => 0.4, // Perasaan sedih (Panik - bisa ada tapi bukan inti)
                ]
            ],
            // Stres Kronis (P04)
            [
                'penyakit_kode' => 'P04',
                'gejala_kodes_cf' => [
                    'G02' => 0.7, // Kelelahan (Stres Kronis)
                    'G03' => 0.5, // Perubahan nafsu makan (Stres Kronis)
                    'G04' => 0.6, // Sakit kepala (Stres Kronis)
                    'G08' => 0.65, // Mudah tersinggung (Stres Kronis)
                    'G09' => 0.55, // Sulit konsentrasi (Stres Kronis)
                    'G16' => 0.7, // Perubahan suasana hati drastis (Stres Kronis)
                    'G01' => 0.8, // Sulit tidur (Stres Kronis)
                ]
            ],
            // Tambahkan lebih banyak hubungan sesuai dengan logika diagnosa Anda
        ];

        // Masukkan data ke tabel pivot
        foreach ($gejalaPenyakitData as $data) {
            $penyakitId = $penyakits[$data['penyakit_kode']];
            foreach ($data['gejala_kodes_cf'] as $gejalaKode => $cfValue) {
                $gejalaId = $gejalas[$gejalaKode];
                DB::table('gejala_penyakit')->insert([
                    'penyakit_id' => $penyakitId,
                    'gejala_id' => $gejalaId,
                    'cf_value' => $cfValue, 
                ]);
            }
        }

        $this->command->info('GejalaPenyakit pivot table seeded with CF values!');
    }
}