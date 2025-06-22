<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Solusi;
use App\Models\Penyakit;

class SolusiSeeder extends Seeder
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

        if ($depresi && $gad && $panik && $stres) {
            Solusi::create([
                'penyakit_id' => $depresi->id,
                'solusi' => 'Cari dukungan profesional (psikolog/psikiater).',
                'tingkat_keparahan' => 5,
                'langkah_langkah' => 'Jadwalkan janji temu, bicarakan perasaan Anda secara terbuka.'
            ]);
            Solusi::create([
                'penyakit_id' => $depresi->id,
                'solusi' => 'Tingkatkan aktivitas fisik secara teratur.',
                'tingkat_keparahan' => 3,
                'langkah_langkah' => 'Mulai dengan jalan kaki 30 menit setiap hari, atau cari olahraga yang Anda nikmati.'
            ]);
            Solusi::create([
                'penyakit_id' => $gad->id,
                'solusi' => 'Pelajari teknik relaksasi seperti pernapasan dalam atau meditasi.',
                'tingkat_keparahan' => 4,
                'langkah_langkah' => 'Gunakan aplikasi meditasi, praktikkan 10-15 menit setiap hari.'
            ]);
            Solusi::create([
                'penyakit_id' => $panik->id,
                'solusi' => 'Identifikasi pemicu serangan panik Anda dan coba hindari atau kelola.',
                'tingkat_keparahan' => 4,
                'langkah_langkah' => 'Catat situasi atau pikiran sebelum serangan panik, cari pola.'
            ]);
            Solusi::create([
                'penyakit_id' => $stres->id,
                'solusi' => 'Atur prioritas dan kelola waktu Anda dengan lebih baik.',
                'tingkat_keparahan' => 3,
                'langkah_langkah' => 'Buat daftar tugas, delegasikan jika memungkinkan, tetapkan batasan.'
            ]);
            Solusi::create([
                'penyakit_id' => $stres->id,
                'solusi' => 'Pastikan Anda mendapatkan tidur yang cukup dan berkualitas.',
                'tingkat_keparahan' => 2,
                'langkah_langkah' => 'Jaga rutinitas tidur, hindari kafein sebelum tidur, ciptakan lingkungan tidur yang nyaman.'
            ]);
        } else {
            $this->command->warn('Skipping SolusiSeeder: Penyakit data not found. Please run PenyakitSeeder first.');
        }
    }
}