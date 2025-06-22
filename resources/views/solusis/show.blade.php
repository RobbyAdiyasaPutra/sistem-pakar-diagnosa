<x-app-layout> {{-- REMOVE @extends('layouts.app') AND @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Solusi untuk Penyakit') }}: {{ $solusi->penyakit->nama_penyakit ?? 'N/A' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">ID Solusi:</p>
                        <p class="text-lg font-semibold">{{ $solusi->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Penyakit Terkait:</p>
                        <p class="text-lg font-semibold">{{ $solusi->penyakit->nama_penyakit ?? 'N/A' }} ({{ $solusi->penyakit->kode_penyakit ?? 'N/A' }})</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Deskripsi Solusi:</p>
                        <p class="text-base text-gray-800 leading-relaxed">{{ $solusi->solusi }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tingkat Keparahan:</p>
                        <p class="text-lg font-semibold">{{ $solusi->tingkat_keparahan ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Langkah-langkah:</p>
                        <p class="text-base text-gray-800 leading-relaxed">{{ $solusi->langkah_langkah ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Dibuat Pada:</p>
                        <p class="text-lg font-semibold">{{ $solusi->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Diperbarui Pada:</p>
                        <p class="text-lg font-semibold">{{ $solusi->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('solusis.edit', $solusi->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                    <a href="{{ route('solusis.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>