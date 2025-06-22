<x-app-layout> {{-- REMOVE @extends('layouts.app') AND @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Solusi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('solusis.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Tambah Solusi Baru</a>

                <table class="min-w-full divide-y divide-gray-200 mt-4">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyakit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solusi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tingkat Keparahan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($solusis as $solusi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $solusi->penyakit->nama_penyakit ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ Str::limit($solusi->solusi, 70) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $solusi->tingkat_keparahan ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('solusis.show', $solusi->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Lihat</a>
                                    <a href="{{ route('solusis.edit', $solusi->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                    <form action="{{ route('solusis.destroy', $solusi->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus solusi ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $solusis->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>