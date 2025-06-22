<x-app-layout> {{-- REMOVE @extends('layouts.app') AND @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Role') }}: {{ $role->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">ID Role:</p>
                        <p class="text-lg font-semibold">{{ $role->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nama Role:</p>
                        <p class="text-lg font-semibold">{{ $role->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Dibuat Pada:</p>
                        <p class="text-lg font-semibold">{{ $role->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Diperbarui Pada:</p>
                        <p class="text-lg font-semibold">{{ $role->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('roles.edit', $role->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                    <a href="{{ route('roles.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>