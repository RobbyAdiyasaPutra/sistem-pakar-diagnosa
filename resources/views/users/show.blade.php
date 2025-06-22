<x-app-layout> {{-- REMOVE @extends('layouts.app') AND @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengguna') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nama:</p>
                        <p class="text-lg font-semibold">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email:</p>
                        <p class="text-lg font-semibold">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Role:</p>
                        <p class="text-lg font-semibold">{{ $user->role->name ?? 'Tidak Ada Role' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status:</p>
                        <p class="text-lg font-semibold">
                            @if ($user->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Dibuat Pada:</p>
                        <p class="text-lg font-semibold">{{ $user->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Diperbarui Pada:</p>
                        <p class="text-lg font-semibold">{{ $user->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('users.edit', $user->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                    <a href="{{ route('users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>