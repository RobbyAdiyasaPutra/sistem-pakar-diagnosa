<x-app-layout> {{-- Replace @extends('layouts.app') and @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Diagnosa') }} #{{ $diagnosa->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">ID Diagnosa:</p>
                        <p class="text-lg font-semibold">{{ $diagnosa->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Pengguna:</p>
                        <p class="text-lg font-semibold">{{ $diagnosa->user->name ?? 'N/A' }} ({{ $diagnosa->user->email ?? 'N/A' }})</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Penyakit Terdiagnosa:</p>
                        <p class="text-lg font-semibold">{{ $diagnosa->penyakit->nama_penyakit ?? 'Tidak Terdiagnosa' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Skor Similaritas:</p>
                        <p class="text-lg font-semibold">{{ $diagnosa->similarity_score ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nilai CF:</p>
                        <p class="text-lg font-semibold">{{ $diagnosa->cf_value ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Gejala yang Dipilih:</p>
                        @forelse ($diagnosa->gejala_terpilih_detail as $gejala)
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 mr-2 mb-2">{{ $gejala->nama_gejala }} ({{ $gejala->kode_gejala }})</span>
                        @empty
                            <p class="text-base text-gray-800">Tidak ada gejala dipilih.</p>
                        @endforelse
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Hasil Diagnosa:</p>
                        <p class="text-base text-gray-800 leading-relaxed">{{ $diagnosa->hasil_diagnosa }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Rekomendasi:</p>
                        <p class="text-base text-gray-800 leading-relaxed">{{ $diagnosa->rekomendasi ?? '-' }}</p>
                    </div>
                    @if (!empty($diagnosa->metadata))
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600">Metadata (JSON):</p>
                            <pre class="bg-gray-100 p-3 rounded-md text-sm overflow-x-auto">{{ json_encode($diagnosa->metadata, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-600">Dibuat Pada:</p>
                        <p class="text-lg font-semibold">{{ $diagnosa->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Diperbarui Pada:</p>
                        <p class="text-lg font-semibold">{{ $diagnosa->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('diagnosas.edit', $diagnosa->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                    @endif
                    <a href="{{ route('diagnosas.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>