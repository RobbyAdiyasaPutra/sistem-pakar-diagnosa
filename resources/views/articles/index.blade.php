{{-- resources/views/articles/index.blade.php --}}

{{-- REMOVE @extends('layouts.app') AND @section('content') --}}
{{-- Use <x-app-layout> as the wrapper component --}}
<x-app-layout>

    {{-- This is how you pass content to the named 'header' slot in layouts/app.blade.php --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Artikel') }}
        </h2>
    </x-slot>

    {{-- The rest of your page content goes here, directly inside x-app-layout --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('articles.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Tambah Artikel Baru</a>

                <table class="min-w-full divide-y divide-gray-200 mt-4">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dipublikasikan Pada</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dilihat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($articles as $article)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($article->title, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $article->author->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $article->published_at?->format('d M Y') ?? 'Draft' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $article->views_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('articles.show', $article->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Lihat</a>
                                    <a href="{{ route('articles.edit', $article->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>