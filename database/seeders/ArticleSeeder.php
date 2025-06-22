<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Mengenal Gejala Awal Depresi dan Cara Mengatasinya',
                'content' => '<p>Depresi adalah kondisi serius yang membutuhkan perhatian. Kenali gejala-gejala awalnya seperti kehilangan minat, perubahan nafsu makan, dan gangguan tidur. Penting untuk mencari bantuan profesional jika Anda atau seseorang yang Anda kenal mengalami gejala ini. Terapi bicara, obat-obatan, dan perubahan gaya hidup dapat sangat membantu.</p><p>Ingat, Anda tidak sendirian. Dukungan dari keluarga dan teman juga sangat berarti dalam proses pemulihan.</p>',
                'image_url' => 'article_images/depresi_gejala.jpg', // Contoh path, pastikan folder storage/app/public/article_images ada
                'tags' => 'depresi, kesehatan mental, gejala, penanganan',
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Strategi Efektif untuk Mengelola Stres Harian',
                'content' => '<p>Stres adalah bagian tak terhindarkan dari kehidupan, tetapi cara kita mengelolanya dapat membuat perbedaan besar. Artikel ini membahas strategi praktis seperti teknik pernapasan, meditasi singkat, pengaturan waktu, dan pentingnya hobi untuk meredakan stres.</p><p>Menerapkan strategi ini secara rutin dapat membantu Anda merasa lebih tenang dan terkendali dalam menghadapi tantangan sehari-hari.</p>',
                'image_url' => 'article_images/stres_manajemen.jpg',
                'tags' => 'stres, manajemen stres, relaksasi, kesehatan',
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Pentingnya Tidur Berkualitas untuk Kesehatan Mental',
                'content' => '<p>Tidur yang cukup dan berkualitas tinggi adalah fondasi penting bagi kesehatan mental yang baik. Kurang tidur dapat memperburuk kecemasan, depresi, dan masalah suasana hati lainnya. Pelajari cara meningkatkan kebersihan tidur Anda.</p><p>Menciptakan rutinitas tidur yang konsisten, menghindari layar sebelum tidur, dan menciptakan lingkungan kamar tidur yang nyaman adalah beberapa tips yang bisa Anda coba.</p>',
                'image_url' => 'article_images/tidur_kualitas.jpg',
                'tags' => 'tidur, kesehatan mental, kebiasaan sehat',
                'published_at' => Carbon::now()->subDays(15),
            ],
            [
                'title' => 'Membangun Resiliensi: Cara Menghadapi Tantangan Hidup',
                'content' => '<p>Resiliensi adalah kemampuan untuk bangkit kembali dari kesulitan. Ini bukan berarti Anda tidak akan merasakan sakit atau kesedihan, melainkan bagaimana Anda merespons dan belajar dari pengalaman tersebut. Kembangkan pola pikir positif, cari dukungan, dan praktikkan self-compassion.</p><p>Resiliensi dapat dilatih dan dikembangkan seiring waktu, membantu Anda menghadapi badai kehidupan dengan lebih baik.</p>',
                'image_url' => 'article_images/resiliensi.jpg',
                'tags' => 'resiliensi, pengembangan diri, tantangan hidup, psikologi positif',
                'published_at' => Carbon::now()->subDays(20),
            ],
        ];

        foreach ($articles as $articleData) {
            $articleData['slug'] = Str::slug($articleData['title']);
            Article::create($articleData);
        }
    }
}