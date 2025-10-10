<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider  extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Chỉ admin mới được truy cập
        Gate::define('is-admin', function (User $user) {
            return $user->isAdmin();
        });

        // Chỉ user thường mới được truy cập
        Gate::define('is-user', function (User $user) {
            return $user->isUser();
        });
    }
}
