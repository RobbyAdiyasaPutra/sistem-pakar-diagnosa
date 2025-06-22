<x-app-layout> {{-- REMOVE @extends('layouts.app') AND @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Penyakit Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <x-validation-errors class="mb-4" />

                <form action="{{ route('penyakits.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-label for="kode_penyakit" value="Kode Penyakit" />
                        <x-input id="kode_penyakit" class="block mt-1 w-full" type="text" name="kode_penyakit" :value="old('kode_penyakit')" required autofocus />
                        <x-input-error for="kode_penyakit" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="nama_penyakit" value="Nama Penyakit" />
                        <x-input id="nama_penyakit" class="block mt-1 w-full" type="text" name="nama_penyakit" :value="old('nama_penyakit')" required />
                        <x-input-error for="nama_penyakit" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="deskripsi" value="Deskripsi" />
                        <textarea id="deskripsi" name="deskripsi" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                        <x-input-error for="deskripsi" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="solusi_umum" value="Solusi Umum" />
                        <textarea id="solusi_umum" name="solusi_umum" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('solusi_umum') }}</textarea>
                        <x-input-error for="solusi_umum" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="gejalas" value="Gejala Terkait" />
                        <select name="gejalas[]" id="gejalas" multiple class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach ($gejalas as $gejala)
                                <option value="{{ $gejala->id }}" {{ in_array($gejala->id, old('gejalas', [])) ? 'selected' : '' }}>
                                    {{ $gejala->nama_gejala }} ({{ $gejala->kode_gejala }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Pilih satu atau beberapa gejala (gunakan Ctrl/Cmd untuk multi-pilih).</p>
                        <x-input-error for="gejalas" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('penyakits.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
                        <x-button class="ms-4">
                            Simpan
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>