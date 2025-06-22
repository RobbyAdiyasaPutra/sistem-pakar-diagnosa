<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Statistik Ringkasan --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    {{-- Total Artikel --}}
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border border-blue-200">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-600">Total Artikel</h3>
                            <p class="text-4xl font-bold text-blue-600 mt-2">{{ $totalArticles ?? 0 }}</p>
                        </div>
                        <i class="fas fa-newspaper text-blue-400 text-5xl"></i>
                    </div>

                    {{-- Total Penyakit --}}
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border border-green-200">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-600">Total Penyakit</h3>
                            <p class="text-4xl font-bold text-green-600 mt-2">{{ $totalPenyakit ?? 0 }}</p>
                        </div>
                        <i class="fas fa-viruses text-green-400 text-5xl"></i>
                    </div>

                    {{-- Total Gejala --}}
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border border-yellow-200">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-600">Total Gejala</h3>
                            <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $totalGejala ?? 0 }}</p>
                        </div>
                        <i class="fas fa-head-side-cough text-yellow-400 text-5xl"></i>
                    </div>

                    {{-- Total Solusi --}}
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border border-red-200">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-600">Total Solusi</h3>
                            <p class="text-4xl font-bold text-red-600 mt-2">{{ $totalSolusi ?? 0 }}</p>
                        </div>
                        <i class="fas fa-prescription-bottle-alt text-red-400 text-5xl"></i>
                    </div>

                    {{-- Total Diagnosa --}}
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border border-purple-200">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-600">Total Diagnosa</h3>
                            <p class="text-4xl font-bold text-purple-600 mt-2">{{ $totalDiagnosa ?? 0 }}</p>
                        </div>
                        <i class="fas fa-notes-medical text-purple-400 text-5xl"></i>
                    </div>

                    {{-- Total Users --}}
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border border-indigo-200">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-600">Total Pengguna</h3>
                            <p class="text-4xl font-bold text-indigo-600 mt-2">{{ $totalUsers ?? 0 }}</p>
                        </div>
                        <i class="fas fa-users text-indigo-400 text-5xl"></i>
                    </div>

                    {{-- Total Kasus --}}
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border border-pink-200">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-600">Total Kasus</h3>
                            <p class="text-4xl font-bold text-pink-600 mt-2">{{ $totalKasus ?? 0 }}</p>
                        </div>
                        <i class="fas fa-clipboard text-pink-400 text-5xl"></i>
                    </div>

                    {{-- Total Roles --}}
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border border-teal-200">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-600">Total Peran (Roles)</h3>
                            <p class="text-4xl font-bold text-teal-600 mt-2">{{ $totalRoles ?? 0 }}</p>
                        </div>
                        <i class="fas fa-user-tag text-teal-400 text-5xl"></i>
                    </div>
                </div>

                <x-monthly-diagnoses-chart
                    :labels="$chartData['labels']"
                    :values="$chartData['data']"
                />

                {{-- Aktivitas Terbaru --}}
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>
                    @if ($recentActivities->isEmpty())
                        <p class="text-gray-600">Tidak ada aktivitas terbaru.</p>
                    @else
                        <ul class="divide-y divide-gray-200">
                            @foreach ($recentActivities as $activity)
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="text-gray-800">
                                            <span class="font-semibold">{{ $activity->user->name ?? 'Pengguna Tidak Dikenal' }}</span>
                                            melakukan diagnosa untuk
                                            <span class="font-semibold">{{ $activity->penyakit->nama_penyakit ?? 'Penyakit Tidak Dikenal' }}</span>.
                                        </p>
                                        <span class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                                    </div>
                                    <a href="{{ route('diagnosas.show', $activity->id) }}" class="text-blue-500 hover:underline text-sm">Lihat Detail</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        {{-- Memuat Chart.js dari CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        {{-- Memuat Font Awesome untuk ikon --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-..." crossorigin="anonymous"></script>
    @endpush
</x-app-layout>