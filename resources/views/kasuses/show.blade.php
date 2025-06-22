<x-app-layout> {{-- Replace @extends('layouts.app') and @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kasus') }}: {{ $kasus->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">ID Kasus:</p>
                        <p class="text-lg font-semibold">{{ $kasus->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Penyakit Terkait:</p>
                        <p class="text-lg font-semibold">{{ $kasus->penyakit->nama_penyakit ?? 'N/A' }} ({{ $kasus->penyakit->kode_penyakit ?? 'N/A' }})</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Gejala Terpilih:</p>
                        @forelse ($kasus->gejalas as $gejala)
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 mr-2 mb-2">{{ $gejala->nama_gejala }} ({{ $gejala->kode_gejala }})</span>
                        @empty
                            <p class="text-base text-gray-800">Tidak ada gejala terkait.</p>
                        @endforelse
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Solusi:</p>
                        <p class="text-base text-gray-800 leading-relaxed">{{ $kasus->solusi ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Keterangan:</p>
                        <p class="text-base text-gray-800 leading-relaxed">{{ $kasus->keterangan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Dibuat Pada:</p>
                        <p class="text-lg font-semibold">{{ $kasus->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Diperbarui Pada:</p>
                        <p class="text-lg font-semibold">{{ $kasus->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('kasuses.edit', $kasus->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                    <a href="{{ route('kasuses.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> {{-- End of x-app-layout --}}