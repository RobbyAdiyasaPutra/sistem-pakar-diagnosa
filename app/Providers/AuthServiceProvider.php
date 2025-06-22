<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User; // Penting: Impor model User Anda

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('access-admin-dashboard', function (User $user) {
            // Pastikan logika ini sesuai dengan bagaimana Anda mendefinisikan admin
            // Contoh ini mengasumsikan ada relasi 'role' dan role 'admin'
            return $user->isAdmin();
        });
    }
}