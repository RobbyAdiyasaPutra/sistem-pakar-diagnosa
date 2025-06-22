<?php

namespace App\Http\Controllers; // Pastikan ini tetap App\Http\Controllers

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\Solusi; // Pastikan model ini diimpor
use App\Models\Diagnosa; // Pastikan model ini diimpor
use App\Models\User; // Pastikan model ini diimpor
use App\Models\Kasus; // Tambahkan ini jika Anda memiliki model Kasus dan ingin statistiknya
use App\Models\Role; // Pastikan model ini diimpor
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache; // Penting untuk caching
use Carbon\Carbon; // Penting untuk tanggal

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with various statistics and charts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Pastikan pengecekan otorisasi admin seperti yang sudah kita diskusikan
        // Ini diasumsikan metode isAdmin() ada di model User Anda
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        // Statistik utama dengan caching (direkomendasikan untuk performa)
        $stats = Cache::remember('dashboard_stats', 3600, function () { // Cache for 1 hour
            return [
                'total_users' => User::count(),
                // 'active_users' => User::where('is_active', true)->count(), // Aktifkan jika Anda memiliki kolom is_active
                'total_penyakit' => Penyakit::count(),
                'total_gejala' => Gejala::count(),
                'total_kasus' => Kasus::count(), // Menggunakan model Kasus
                'total_diagnoses' => Diagnosa::count(),
                'total_articles' => Article::count(),
                'total_solusi' => Solusi::count(), // Tambahkan statistik Solusi
                'total_roles' => Role::count(), // Tambahkan statistik Role
                'diagnoses_today' => Diagnosa::whereDate('created_at', Carbon::today())->count(),
                'new_users_week' => User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            ];
        });

        // Contoh data untuk grafik (misal: diagnosa per bulan) - bisa Anda aktifkan nanti
        $chartData = $this->getMonthlyDiagnosesData();

        // Aktivitas terbaru (misal: diagnosa terbaru atau user baru)
        $recentActivities = Diagnosa::with('user', 'penyakit')
                                    ->latest()
                                    ->take(10)
                                    ->get();

        // Lewatkan semua data ke view
        return view('dashboard', [ // Pastikan path view Anda adalah 'dashboard' jika file di resources/views/dashboard.blade.php
            'stats' => $stats,
            'chartData' => $chartData,
            'recentActivities' => $recentActivities,
            'activePage' => 'dashboard', // Untuk penanda menu aktif di sidebar admin
            // Teruskan variabel tunggal dari $stats untuk kompatibilitas jika blade Anda masih mengharapkan variabel individual
            'totalArticles' => $stats['total_articles'],
            'totalPenyakit' => $stats['total_penyakit'],
            'totalGejala' => $stats['total_gejala'],
            'totalSolusi' => $stats['total_solusi'],
            'totalDiagnosa' => $stats['total_diagnoses'],
            'totalUsers' => $stats['total_users'],
            'totalKasus' => $stats['total_kasus'], // Pastikan ini juga ada di $stats
            'totalRoles' => $stats['total_roles'], // Pastikan ini juga ada di $stats
        ]);
    }

    /**
     * Get monthly diagnoses data for charts.
     *
     * @return array
     */
    private function getMonthlyDiagnosesData()
    {
        // Mendapatkan data diagnosa per bulan untuk 6 bulan terakhir
        $months = [];
        $diagnosesCount = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            $diagnosesCount[] = Diagnosa::whereMonth('created_at', $date->month)
                                        ->whereYear('created_at', $date->year)
                                        ->count();
        }

        return [
            'labels' => $months,
            'data' => $diagnosesCount
        ];
    }

    /**
     * Get recent activities (e.g., latest diagnoses or user registrations).
     * This is an example, you can expand it.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentActivities()
    {
        return Cache::remember('recent_activities', 3600, function () {
            // Misalnya mengambil 10 diagnosa terbaru
            return Diagnosa::with(['user', 'penyakit'])
                ->latest()
                ->take(10)
                ->get();
        });
    }

    // Jika Anda menggunakan Livewire, metode render ini untuk komponen Livewire
    // Jika tidak, Anda bisa menghapusnya atau mengabaikannya.
    public function render()
    {
        return view('livewire.dashboard', [
            'totalArticles' => Article::count(),
            'totalPenyakit' => Penyakit::count(),
            'totalGejala' => Gejala::count(),
            // Anda juga perlu menambahkan variabel lain di sini jika livewire/dashboard.blade.php membutuhkannya
        ]);
    }
}