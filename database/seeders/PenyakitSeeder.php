<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penyakit;
use Illuminate\Support\Str;

class PenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penyakits = [
            [
                'kode_penyakit' => 'P01',
                'nama_penyakit' => 'Depresi',
                'deskripsi' => 'Depresi adalah gangguan suasana hati yang menyebabkan perasaan sedih dan kehilangan minat secara terus-menerus. Ini mempengaruhi cara Anda merasa, berpikir, dan berperilaku, serta dapat menyebabkan berbagai masalah emosional dan fisik.',
                'penanganan_umum' => 'Terapi bicara (psikoterapi), obat-obatan antidepresan, perubahan gaya hidup (olahraga, diet sehat, tidur cukup), dukungan sosial.',
            ],
            [
                'kode_penyakit' => 'P02',
                'nama_penyakit' => 'Gangguan Kecemasan Umum (GAD)',
                'deskripsi' => 'Gangguan kecemasan umum ditandai dengan kekhawatiran yang berlebihan dan tidak terkontrol tentang berbagai hal dalam kehidupan sehari-hari, bahkan ketika tidak ada alasan yang jelas untuk khawatir.',
                'penanganan_umum' => 'Terapi kognitif perilaku (CBT), obat anti-kecemasan, teknik relaksasi (meditasi, yoga), mengurangi kafein dan alkohol.',
            ],
            [
                'kode_penyakit' => 'P03',
                'nama_penyakit' => 'Gangguan Panik',
                'deskripsi' => 'Gangguan panik melibatkan serangan panik yang berulang dan tidak terduga, yang merupakan periode intens ketakutan atau ketidaknyamanan yang tiba-tiba dan mencapai puncaknya dalam beberapa menit.',
                'penanganan_umum' => 'Terapi kognitif perilaku (CBT), obat-obatan (antidepresan, benzodiazepine), teknik pernapasan, menghindari pemicu.',
            ],
            [
                'kode_penyakit' => 'P04',
                'nama_penyakit' => 'Stres Kronis',
                'deskripsi' => 'Stres kronis adalah respons tubuh terhadap tekanan yang berlangsung dalam jangka waktu lama. Ini dapat memiliki dampak negatif yang signifikan pada kesehatan fisik dan mental.',
                'penanganan_umum' => 'Manajemen stres (olahraga, hobi, istirahat), teknik relaksasi, tidur yang cukup, diet seimbang, mencari dukungan.',
            ],
        ];

        foreach ($penyakits as $penyakitData) {
            $penyakitData['slug'] = Str::slug($penyakitData['nama_penyakit']);
            Penyakit::create($penyakitData);
        }
    }
}