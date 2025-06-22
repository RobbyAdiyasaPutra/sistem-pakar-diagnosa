<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Import model User
use App\Models\Role; // Import model Role jika ada relasi atau untuk default role
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Untuk validasi role

class RegisterController extends Controller
{
    /**
     * Show the application registration form.
     */
    public function showRegistrationForm()
    {
        // Jika Anda ingin user bisa memilih role saat daftar (jarang terjadi di publik)
        // Atau hanya untuk admin yang membuat user baru
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Default role for new registrations is usually 'user'
            // If you allow admin to register other types, uncomment and adjust:
            // 'role' => ['nullable', 'string', Rule::in(['admin', 'user'])],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role for new registrations
            'is_active' => true, // Default to active
        ]);

        // Opsional: Langsung login user setelah registrasi
        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}