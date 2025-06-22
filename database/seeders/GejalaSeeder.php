<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gejala;
use Illuminate\Support\Str;

class GejalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gejalas = [
            ['kode_gejala' => 'G01', 'nama_gejala' => 'Sulit tidur atau insomnia', 'kategori' => 'Fisik'],
            ['kode_gejala' => 'G02', 'nama_gejala' => 'Kelelahan atau kurang energi', 'kategori' => 'Fisik'],
            ['kode_gejala' => 'G03', 'nama_gejala' => 'Perubahan nafsu makan (bertambah/berkurang)', 'kategori' => 'Fisik'],
            ['kode_gejala' => 'G04', 'nama_gejala' => 'Sakit kepala atau nyeri tubuh', 'kategori' => 'Fisik'],
            ['kode_gejala' => 'G05', 'nama_gejala' => 'Detak jantung cepat atau berdebar', 'kategori' => 'Fisik'],
            ['kode_gejala' => 'G06', 'nama_gejala' => 'Berkeringat berlebihan', 'kategori' => 'Fisik'],
            ['kode_gejala' => 'G07', 'nama_gejala' => 'Gelisah atau tidak bisa diam', 'kategori' => 'Perilaku'],
            ['kode_gejala' => 'G08', 'nama_gejala' => 'Mudah tersinggung atau marah', 'kategori' => 'Emosional'],
            ['kode_gejala' => 'G09', 'nama_gejala' => 'Kesulitan konsentrasi', 'kategori' => 'Kognitif'],
            ['kode_gejala' => 'G10', 'nama_gejala' => 'Perasaan sedih atau putus asa', 'kategori' => 'Emosional'],
            ['kode_gejala' => 'G11', 'nama_gejala' => 'Kehilangan minat pada aktivitas yang disukai', 'kategori' => 'Emosional'],
            ['kode_gejala' => 'G12', 'nama_gejala' => 'Pikiran untuk menyakiti diri sendiri atau bunuh diri', 'kategori' => 'Kognitif'],
            ['kode_gejala' => 'G13', 'nama_gejala' => 'Penarikan diri dari sosial', 'kategori' => 'Perilaku'],
            ['kode_gejala' => 'G14', 'nama_gejala' => 'Kecemasan berlebihan atau panik', 'kategori' => 'Emosional'],
            ['kode_gejala' => 'G15', 'nama_gejala' => 'Perasaan tidak berharga atau bersalah', 'kategori' => 'Emosional'],
            ['kode_gejala' => 'G16', 'nama_gejala' => 'Perubahan suasana hati drastis', 'kategori' => 'Emosional'],
            ['kode_gejala' => 'G17', 'nama_gejala' => 'Sulit mengambil keputusan', 'kategori' => 'Kognitif'],
            ['kode_gejala' => 'G18', 'nama_gejala' => 'Cemas setiap saat, tanpa alasan jelas', 'kategori' => 'Emosional'],
            ['kode_gejala' => 'G19', 'nama_gejala' => 'Menghindari situasi sosial', 'kategori' => 'Perilaku'],
            ['kode_gejala' => 'G20', 'nama_gejala' => 'Merasa terputus dari kenyataan', 'kategori' => 'Kognitif'],
        ];

        foreach ($gejalas as $gejala) {
            Gejala::create($gejala);
        }
    }
}