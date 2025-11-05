<?php

namespace App\Providers;

use App\Repositories\CartRepository;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\OrderItemRepository;
use App\Repositories\Interfaces\OrderItemRepositoryInterface;

use App\Repositories\CouponRepository;
use App\Repositories\Interfaces\CouponRepositoryInterface;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Các bind sẵn có
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderItemRepositoryInterface::class, OrderItemRepository::class);
        $this->app->bind(CouponRepositoryInterface::class, CouponRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
