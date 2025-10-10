<?php

namespace App\Providers;

use App\Http\ViewComposers\CartComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Gắn CartComposer vào tất cả các view (hoặc chỉ layout chính)
        View::composer('*', CartComposer::class);
        // Nếu muốn chỉ áp dụng cho layout master:
        // View::composer('layouts.master', CartComposer::class);
    }
}
