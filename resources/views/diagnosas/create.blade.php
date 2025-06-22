<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mulai Diagnosa Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <x-validation-errors class="mb-4" />

                <h3 class="text-lg font-medium text-gray-900 mb-4">Pilih Gejala yang Anda Alami:</h3>

                <form action="{{ route('diagnosas.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                        @forelse ($gejalas as $gejala)
                            <div class="flex items-center">
                                <input type="checkbox" name="gejala_terpilih[]" id="gejala_{{ $gejala->id }}" value="{{ $gejala->id }}"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    {{ in_array($gejala->id, old('gejala_terpilih', [])) ? 'checked' : '' }}>
                                <label for="gejala_{{ $gejala->id }}" class="ms-2 text-sm text-gray-900 cursor-pointer">{{ $gejala->nama_gejala }}</label>
                            </div>
                        @empty
                            <p class="col-span-full text-gray-600">Tidak ada gejala tersedia. Mohon hubungi administrator.</p>
                        @endforelse
                    </div>

                    {{-- Opsional: tampilkan error spesifik untuk gejala_terpilih --}}
                    @error('gejala_terpilih')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Batal
                        </a>
                        <x-button class="ms-4">
                            Proses Diagnosa
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>