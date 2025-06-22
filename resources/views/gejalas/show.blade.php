<x-app-layout> {{-- Replace @extends('layouts.app') and @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Gejala') }}: {{ $gejala->nama_gejala }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Kode Gejala:</p>
                        <p class="text-lg font-semibold">{{ $gejala->kode_gejala }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nama Gejala:</p>
                        <p class="text-lg font-semibold">{{ $gejala->nama_gejala }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Kategori:</p>
                        <p class="text-lg font-semibold">{{ $gejala->kategori ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('gejalas.edit', $gejala->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                    <a href="{{ route('gejalas.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> {{-- End of x-app-layout --}}