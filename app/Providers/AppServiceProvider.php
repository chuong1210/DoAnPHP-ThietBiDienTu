<?php

namespace App\Providers;

use App\Http\Controllers\Frontend\AuthClientController;
use App\Http\ViewComposers\LanguageComposer;
use App\Http\ViewComposers\MenuComposer;
use App\Http\ViewComposers\SystemComposer;
use App\Repositories\CartRepository;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Carbon\Carbon;
use DateTime;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
