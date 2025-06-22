<x-app-layout> {{-- REMOVE @extends('layouts.app') AND @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kasus') }}: {{ $kasus->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <x-validation-errors class="mb-4" />

                <form action="{{ route('kasuses.update', $kasus->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-label for="penyakit_id" value="Penyakit Terkait" />
                        <select name="penyakit_id" id="penyakit_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="">Pilih Penyakit</option>
                            @foreach ($penyakits as $penyakit)
                                <option value="{{ $penyakit->id }}" {{ old('penyakit_id', $kasus->penyakit_id) == $penyakit->id ? 'selected' : '' }}>
                                    {{ $penyakit->nama_penyakit }} ({{ $penyakit->kode_penyakit }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="penyakit_id" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="gejalas" value="Gejala Terpilih" />
                        <select name="gejalas[]" id="gejalas" multiple class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            @foreach ($gejalas as $gejala)
                                <option value="{{ $gejala->id }}" {{ in_array($gejala->id, old('gejalas', $kasus->gejalas->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $gejala->nama_gejala }} ({{ $gejala->kode_gejala }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Pilih satu atau beberapa gejala (gunakan Ctrl/Cmd untuk multi-pilih).</p>
                        <x-input-error for="gejalas" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="solusi" value="Solusi Kasus" />
                        <textarea id="solusi" name="solusi" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('solusi', $kasus->solusi) }}</textarea>
                        <x-input-error for="solusi" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="keterangan" value="Keterangan (Opsional)" />
                        <textarea id="keterangan" name="keterangan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('keterangan', $kasus->keterangan) }}</textarea>
                        <x-input-error for="keterangan" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('kasuses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
                        <x-button class="ms-4">
                            Update
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>