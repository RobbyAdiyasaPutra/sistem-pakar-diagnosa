<x-app-layout> {{-- REMOVE @extends('layouts.app') AND @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Diagnosa') }}
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
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Diagnosa "create" route is where users select symptoms to start a diagnosis --}}
                <a href="{{ route('diagnosas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Mulai Diagnosa Baru</a>

                <table class="min-w-full divide-y divide-gray-200 mt-4">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyakit Hasil</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hasil Diagnosa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor Similaritas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($diagnosas as $diagnosa)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $diagnosa->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $diagnosa->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $diagnosa->penyakit->nama_penyakit ?? 'Tidak Terdiagnosa' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($diagnosa->hasil_diagnosa, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $diagnosa->similarity_score ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('diagnosas.show', $diagnosa->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Lihat</a>
                                    @if (Auth::user()->isAdmin()) {{-- Hanya admin yang bisa edit/hapus --}}
                                        <a href="{{ route('diagnosas.edit', $diagnosa->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                        <form action="{{ route('diagnosas.destroy', $diagnosa->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus diagnosa ini?')">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $diagnosas->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>