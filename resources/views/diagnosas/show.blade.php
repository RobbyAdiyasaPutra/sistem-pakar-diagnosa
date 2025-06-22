<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Diagnosa Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <h3 class="text-2xl font-bold text-gray-900 mb-6 print:text-black print:text-center">Detail Hasil Diagnosa</h3>
                <hr class="mb-6 print:hidden">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-600">ID Diagnosa:</p>
                        <p class="text-lg font-semibold">{{ $diagnosa->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Dilakukan Oleh:</p>
                        <p class="text-lg font-semibold">{{ $diagnosa->user->name ?? 'Pengguna Tidak Dikenal' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Diagnosa:</p>
                        <p class="text-lg font-semibold">{{ $diagnosa->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tingkat Kemiripan (Similarity Score):</p>
                        <p class="text-lg font-semibold">{{ round($diagnosa->similarity_score, 2) }}%</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nilai Certainty Factor (CF Value):</p>
                        <p class="text-lg font-semibold">{{ round($diagnosa->cf_value, 2) }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-sm text-gray-600 mb-2">Gejala yang Dipilih:</p>
                    <ul class="list-disc list-inside bg-gray-50 p-4 rounded-md">
                        @forelse ($diagnosa->gejala_terpilih_detail as $gejala)
                            <li class="text-gray-800">{{ $gejala->nama_gejala }}</li>
                        @empty
                            <li class="text-gray-500">Tidak ada gejala yang tercatat untuk diagnosa ini.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="mb-6">
                    <p class="text-sm text-gray-600 mb-2">Hasil Diagnosa:</p>
                    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-md text-xl font-bold">
                        {{ $diagnosa->hasil_diagnosa }}
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-sm text-gray-600 mb-2">Rekomendasi:</p>
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-md text-base">
                        {!! nl2br(e($diagnosa->rekomendasi)) !!} {{-- nl2br untuk baris baru, e() untuk escape --}}
                    </div>
                </div>

                <div class="mt-8 flex justify-between items-center print:hidden">
                    <a href="{{ route('diagnosas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat
                    </a>

                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-print mr-2"></i> Cetak Hasil
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Tambahkan CSS untuk keperluan print. Letakkan di bagian <head> dari layout utama Anda (app.blade.php) atau di file CSS terpisah --}}
<style>
    @media print {
        /* Sembunyikan elemen-elemen yang tidak perlu saat dicetak */
        header, .print\:hidden, nav, footer, .py-12 > div > div:first-child {
            display: none !important;
        }
        body {
            background-color: #fff !important; /* Pastikan latar belakang putih */
            color: #000 !important; /* Pastikan teks hitam */
            margin: 0; /* Hapus margin halaman */
            padding: 0; /* Hapus padding halaman */
        }
        .max-w-4xl.mx-auto.sm\:px-6.lg\:px-8 {
            max-width: 100% !important; /* Lebarkan konten untuk cetak */
            padding: 0 !important;
            margin: 0 !important;
        }
        .shadow-xl.sm\:rounded-lg {
            box-shadow: none !important; /* Hapus bayangan */
            border-radius: 0 !important; /* Hapus border-radius */
        }
        .p-6 {
            padding: 0 !important; /* Hapus padding agar lebih rapi */
        }
        .print\:text-black {
            color: black !important;
        }
        .print\:text-center {
            text-align: center !important;
        }
    }
</style>

{{-- Jika Anda ingin menggunakan ikon Font Awesome, pastikan untuk menautkan CSS-nya di layout utama Anda (app.blade.php) --}}
{{-- Contoh: <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}