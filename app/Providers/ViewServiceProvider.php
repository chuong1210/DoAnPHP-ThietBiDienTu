<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use App\Models\ChatMessage; // Giả sử model của bạn tên là ChatMessage

class ViewServiceProvider extends ServiceProvider
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
        View::composer('admin.partials.header', function ($view) {
            $totalNotifications = 0;
            // Đảm bảo model tồn tại trước khi truy vấn
            if (class_exists(ChatMessage::class)) {
                $totalNotifications = ChatMessage::whereHas('room', function ($q) {
                    $q->where('status', 'open');
                })
                    ->where('is_admin', false)
                    ->where('is_read', false)
                    ->count();
            }

            $view->with('totalNotifications', $totalNotifications);
        });

        // Sử dụng View Composer để chia sẻ dữ liệu cho một partial view cụ thể
        View::composer('admin.partials.sidebar', function ($view) {
            // Truy vấn số đơn hàng chờ xử lý
            $pendingOrdersCount = Order::where('status', 'pending')->count();

            // Truy vấn số tin nhắn chưa đọc
            // Đảm bảo model ChatMessage tồn tại và đúng namespace
            $unreadChatCount = 0;
            if (class_exists(ChatMessage::class)) {
                $unreadChatCount = ChatMessage::whereHas('room', function ($q) {
                    $q->where('status', 'open');
                })
                    ->where('is_admin', false)
                    ->where('is_read', false)
                    ->count();
            }

            // Chia sẻ các biến này cho view
            $view->with('pendingOrdersCount', $pendingOrdersCount)
                ->with('unreadChatCount', $unreadChatCount);
        });
    }
}
