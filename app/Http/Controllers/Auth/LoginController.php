<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the application's login form.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Kita akan buat view ini nanti
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerate session untuk mencegah session fixation
            $request->session()->regenerate();

            // Redirect ke halaman yang diinginkan setelah login sukses
            // Anda bisa menggantinya ke '/dashboard' atau '/home'
            return redirect()->intended('/dashboard');
        }

        // Jika autentikasi gagal
        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect ke halaman login atau halaman utama
        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}