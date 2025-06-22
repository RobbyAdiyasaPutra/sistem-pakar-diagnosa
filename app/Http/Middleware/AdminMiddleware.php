<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User; // Sudah benar, mengimpor model User

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect ke halaman login jika belum login
        }

        // Get the authenticated user and type-hint it for better IDE support
        /** @var User $user */ // Sudah benar, untuk membantu autokomplit IDE
        $user = Auth::user();

        // Cek apakah user adalah admin menggunakan method isAdmin() dari model User
        // Jika metode isAdmin() belum ada di model User, Anda perlu menambahkannya (lihat contoh di atas)
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized access.'); // Tampilkan error 403 jika bukan admin
        }

        return $next($request);
    }
}