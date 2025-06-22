<x-app-layout> {{-- REMOVE @extends('layouts.app') AND @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mulai Diagnosa Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <x-validation-errors class="mb-4" />

                <h3 class="text-xl font-semibold mb-4">Pilih Gejala yang Anda Alami:</h3>

                <form action="{{ route('diagnosas.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                        @foreach ($gejalas as $gejala)
                            <div class="flex items-center">
                                <x-checkbox id="gejala_{{ $gejala->id }}" name="gejala_terpilih[]" value="{{ $gejala->id }}" :checked="in_array($gejala->id, old('gejala_terpilih', []))" />
                                <label for="gejala_{{ $gejala->id }}" class="ms-2 text-sm text-gray-600">{{ $gejala->nama_gejala }} ({{ $gejala->kode_gejala }})</label>
                            </div>
                        @endforeach
                    </div>
                    <x-input-error for="gejala_terpilih" class="mt-2" />
                    <x-input-error for="gejala_terpilih.*" class="mt-2" /> {{-- Untuk setiap item array --}}


                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('diagnosas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
                        <x-button class="ms-4">
                            Diagnosa Sekarang
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>