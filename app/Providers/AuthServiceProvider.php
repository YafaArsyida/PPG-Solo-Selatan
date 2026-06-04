<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // layer 1 peran
        Gate::define('is-superadmin', function ($user) {
            return $user->isSuperAdmin();
        });

        Gate::define('is-admin', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('is-user', function ($user) {
            return $user->isUser();
        });

        // layer 2 view
        Gate::define('view-dashboard', function ($user) {
            return true;
        });

        Gate::define('view-administrasi', function ($user) {
            return $user->isSuperAdmin()
                || $user->isAdmin();
        });

        Gate::define('view-operasional', function ($user) {
            return $user->isSuperAdmin()
                || $user->isAdmin();
        });

        Gate::define('view-kurikulum', function ($user) {
            return $user->isSuperAdmin()
                || $user->isAdmin();
        });

        Gate::define('view-modul', function ($user) {
            return $user->isSuperAdmin()
                || $user->isAdmin();
        });

        Gate::define('view-sistem', function ($user) {
            return $user->isSuperAdmin();
        });

        // layer 3 special
        Gate::define('manage-periode', function ($user) {
            return $user->isSuperAdmin()
                || $user->isAdminDaerah();
        });

        Gate::define('manage-aspek', function ($user) {
            return $user->isSuperAdmin()
                || $user->isAdminDaerah();
        });
    }
}
