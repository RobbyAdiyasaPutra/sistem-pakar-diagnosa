
<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Daftar Artikel
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

            {{-- Tombol Tambah Artikel Baru --}}
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900">Daftar Artikel</h3>
                    <a href="{{ route('articles.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-plus mr-2"></i> Tambah Artikel Baru
                </a>
            </div>

            <div class="card shadow mb-4"> {{-- Menggunakan struktur card dari gambar --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>JUDUL</th>
                                    <th>PENULIS</th>
                                    <th>DIPUBLIKASIKAN PADA</th>
                                    <th>DILIHAT</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($articles as $article) {{-- Gunakan $articles sesuai dengan apa yang dilewatkan dari controller --}}
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $article->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $article->author->name ?? 'N/A' }}</td> {{-- Asumsi ada relasi author --}}
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $article->views ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('articles.show', $article->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Lihat</a>
                                            <a href="{{ route('articles.edit', $article->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Tidak ada artikel yang tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                {{ $articles->links() }} {{-- Pastikan variabel $articles adalah instance paginator --}}
            </div>
        </div>
    </div>
</div>
</x-app-layout>