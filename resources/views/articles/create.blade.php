<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Buat Artikel Baru
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <x-validation-errors class="mb-4" />

            <form action="{{ route('articles.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <x-label for="title" value="Judul Artikel" />
                    <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                    <x-input-error for="title" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-label for="content" value="Konten Artikel" />
                    <textarea id="content" name="content" rows="10" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('content') }}</textarea>
                    <x-input-error for="content" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-label for="image_url" value="URL Gambar (Opsional)" />
                    <x-input id="image_url" class="block mt-1 w-full" type="url" name="image_url" :value="old('image_url')" />
                    <x-input-error for="image_url" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-label for="tags" value="Tags (dipisahkan koma, Opsional)" />
                    <x-input id="tags" class="block mt-1 w-full" type="text" name="tags" :value="old('tags')" />
                    <x-input-error for="tags" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-label for="author_id" value="Penulis" />
                    <select name="author_id" id="author_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="">Pilih Penulis</option>
                        @foreach ($authors as $author) {{-- Pastikan variabel $authors dilewatkan dari controller --}}
                            <option value="{{ $author->id }}" {{ old('author_id', Auth::id()) == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error for="author_id" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-label for="published_at" value="Tanggal Publikasi (Opsional)" />
                    <x-input id="published_at" class="block mt-1 w-full" type="datetime-local" name="published_at" :value="old('published_at')" />
                    <x-input-error for="published_at" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('articles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
                    <x-button class="ms-4">
                        Simpan
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>