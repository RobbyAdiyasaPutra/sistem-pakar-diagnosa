<x-app-layout> {{-- Replace @extends('layouts.app') and @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Artikel') }}: {{ $article->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4">
                    <h3 class="text-2xl font-bold mb-2">{{ $article->title }}</h3>
                    <p class="text-sm text-gray-600">Oleh: {{ $article->author->name ?? 'Penulis Tidak Dikenal' }} |
                        Diterbitkan: {{ $article->published_at?->format('d M Y') ?? 'Belum Dipublikasikan' }} |
                        Dilihat: {{ $article->views_count }} kali
                    </p>
                    @if ($article->tags)
                        <p class="text-sm text-gray-500 mt-1">Tags: {{ $article->tags }}</p>
                    @endif
                </div>

                @if ($article->image_url)
                    <div class="mb-4">
                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="max-w-full h-auto rounded-lg shadow-md">
                    </div>
                @endif

                <div class="prose max-w-none text-gray-800 leading-relaxed mb-6">
                    {{-- Consider using a markdown parser if content is markdown --}}
                    {!! nl2br(e($article->content)) !!}
                </div>

                <div class="mt-6">
                    <a href="{{ route('articles.edit', $article->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                    <a href="{{ route('articles.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>