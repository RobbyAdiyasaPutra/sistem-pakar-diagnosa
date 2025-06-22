<x-app-layout> {{-- REMOVE @extends('layouts.app') AND @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Penyakit') }}: {{ $penyakit->nama_penyakit }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Kode Penyakit:</p>
                        <p class="text-lg font-semibold">{{ $penyakit->kode_penyakit }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nama Penyakit:</p>
                        <p class="text-lg font-semibold">{{ $penyakit->nama_penyakit }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Slug:</p>
                        <p class="text-lg font-semibold">{{ $penyakit->slug }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Deskripsi:</p>
                        <p class="text-base text-gray-800 leading-relaxed">{{ $penyakit->deskripsi }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Solusi Umum:</p>
                        <p class="text-base text-gray-800 leading-relaxed">{{ $penyakit->solusi_umum }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Gejala Terkait:</p>
                        @forelse ($penyakit->gejalas as $gejala)
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 mr-2 mb-2">{{ $gejala->nama_gejala }} ({{ $gejala->kode_gejala }})</span>
                        @empty
                            <p class="text-base text-gray-800">Tidak ada gejala terkait.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('penyakits.edit', $penyakit->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                    <a href="{{ route('penyakits.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>