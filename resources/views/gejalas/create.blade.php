<x-app-layout> {{-- REMOVE @extends('layouts.app') AND @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Gejala Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <x-validation-errors class="mb-4" />

                <form action="{{ route('gejalas.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-label for="kode_gejala" value="Kode Gejala" />
                        <x-input id="kode_gejala" class="block mt-1 w-full" type="text" name="kode_gejala" :value="old('kode_gejala')" required autofocus />
                        <x-input-error for="kode_gejala" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="nama_gejala" value="Nama Gejala" />
                        <x-input id="nama_gejala" class="block mt-1 w-full" type="text" name="nama_gejala" :value="old('nama_gejala')" required />
                        <x-input-error for="nama_gejala" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="kategori" value="Kategori (Opsional)" />
                        <x-input id="kategori" class="block mt-1 w-full" type="text" name="kategori" :value="old('kategori')" />
                        <x-input-error for="kategori" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('gejalas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
                        <x-button class="ms-4">
                            Simpan
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>