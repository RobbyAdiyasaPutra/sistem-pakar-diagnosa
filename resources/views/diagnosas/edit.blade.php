<x-app-layout> {{-- REMOVE @extends('layouts.app') AND @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Diagnosa') }} #{{ $diagnosa->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <x-validation-errors class="mb-4" />

                <form action="{{ route('diagnosas.update', $diagnosa->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-label for="user_id" value="Pengguna" />
                        <select name="user_id" id="user_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="">Pilih Pengguna</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $diagnosa->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="user_id" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="penyakit_id" value="Penyakit Terdiagnosa (Opsional)" />
                        <select name="penyakit_id" id="penyakit_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Tidak Terdiagnosa / Pilih Penyakit</option>
                            @foreach ($penyakits as $penyakit)
                                <option value="{{ $penyakit->id }}" {{ old('penyakit_id', $diagnosa->penyakit_id) == $penyakit->id ? 'selected' : '' }}>
                                    {{ $penyakit->nama_penyakit }} ({{ $penyakit->kode_penyakit }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="penyakit_id" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="gejala_terpilih" value="Gejala Terpilih" />
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($gejalas as $gejala)
                                <div class="flex items-center">
                                    <x-checkbox id="gejala_edit_{{ $gejala->id }}" name="gejala_terpilih[]" value="{{ $gejala->id }}" :checked="in_array($gejala->id, old('gejala_terpilih', $diagnosa->gejala_terpilih ?? []))" />
                                    <label for="gejala_edit_{{ $gejala->id }}" class="ms-2 text-sm text-gray-600">{{ $gejala->nama_gejala }} ({{ $gejala->kode_gejala }})</label>
                                </div>
                            @endforeach
                        </div>
                        <x-input-error for="gejala_terpilih" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="similarity_score" value="Skor Similaritas (Opsional)" />
                        <x-input id="similarity_score" class="block mt-1 w-full" type="number" step="0.01" name="similarity_score" :value="old('similarity_score', $diagnosa->similarity_score)" />
                        <x-input-error for="similarity_score" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="cf_value" value="Nilai CF (Opsional)" />
                        <x-input id="cf_value" class="block mt-1 w-full" type="number" step="0.01" name="cf_value" :value="old('cf_value', $diagnosa->cf_value)" />
                        <x-input-error for="cf_value" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="hasil_diagnosa" value="Hasil Diagnosa" />
                        <textarea id="hasil_diagnosa" name="hasil_diagnosa" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('hasil_diagnosa', $diagnosa->hasil_diagnosa) }}</textarea>
                        <x-input-error for="hasil_diagnosa" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="rekomendasi" value="Rekomendasi (Opsional)" />
                        <textarea id="rekomendasi" name="rekomendasi" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('rekomendasi', $diagnosa->rekomendasi) }}</textarea>
                        <x-input-error for="rekomendasi" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="metadata" value="Metadata (JSON, Opsional)" />
                        <textarea id="metadata" name="metadata" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('metadata', json_encode($diagnosa->metadata, JSON_PRETTY_PRINT)) }}</textarea>
                        <x-input-error for="metadata" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('diagnosas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
                        <x-button class="ms-4">
                            Update
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>