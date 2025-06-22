<x-app-layout> {{-- REMOVE @extends('layouts.app') AND @section('content') --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pengguna Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <x-validation-errors class="mb-4" />

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-label for="name" value="Nama" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error for="name" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="email" value="Email" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        <x-input-error for="email" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="password" value="Password" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error for="password" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="password_confirmation" value="Konfirmasi Password" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error for="password_confirmation" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="role_id" value="Role" />
                        <select name="role_id" id="role_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="">Pilih Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="role_id" class="mt-2" />
                    </div>

                    <div class="mb-4 flex items-center">
                        <x-checkbox id="is_active" name="is_active" :checked="old('is_active', true)" />
                        <x-label for="is_active" class="ms-2" value="Aktif" />
                        <x-input-error for="is_active" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
                        <x-button class="ms-4">
                            Simpan
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>