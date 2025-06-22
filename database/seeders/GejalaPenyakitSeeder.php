<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Gunakan Facade DB
use App\Models\Gejala; // Opsional, jika ingin mencari ID berdasarkan kode/nama
use App\Models\Penyakit; // Opsional, jika ingin mencari ID berdasarkan kode/nama

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

        // Definisi hubungan gejala dan penyakit
        $gejalaPenyakitData = [
            // Depresi (P01)
            [
                'penyakit_kode' => 'P01',
                'gejala_kodes' => [
                    'G01', 'G02', 'G03', 'G09', 'G10', 'G11', 'G12', 'G13', 'G15', 'G17'
                ]
            ],
            // Gangguan Kecemasan Umum (GAD) (P02)
            [
                'penyakit_kode' => 'P02',
                'gejala_kodes' => [
                    'G05', 'G06', 'G07', 'G08', 'G09', 'G14', 'G18', 'G17'
                ]
            ],
            // Gangguan Panik (P03)
            [
                'penyakit_kode' => 'P03',
                'gejala_kodes' => [
                    'G05', 'G06', 'G07', 'G14', 'G04', 'G01' // Detak jantung, keringat, gelisah, panik, sakit kepala, sulit tidur
                ]
            ],
            // Stres Kronis (P04)
            [
                'penyakit_kode' => 'P04',
                'gejala_kodes' => [
                    'G02', 'G03', 'G04', 'G08', 'G09', 'G16', 'G01' // Kelelahan, nafsu makan, sakit kepala, mudah tersinggung, sulit konsentrasi, mood drastis, sulit tidur
                ]
            ],
            // Tambahkan lebih banyak hubungan sesuai dengan logika diagnosa Anda
        ];

        // Masukkan data ke tabel pivot
        foreach ($gejalaPenyakitData as $data) {
            $penyakitId = $penyakits[$data['penyakit_kode']];
            foreach ($data['gejala_kodes'] as $gejalaKode) {
                $gejalaId = $gejalas[$gejalaKode];
                DB::table('gejala_penyakit')->insert([
                    'penyakit_id' => $penyakitId,
                    'gejala_id' => $gejalaId,
                    // Jika Anda menambahkan timestamps di migrasi, Anda juga perlu menambahkannya di sini:
                    // 'created_at' => now(),
                    // 'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('GejalaPenyakit pivot table seeded!');
    }
}