<?php

namespace App\Http\ViewComposers;

use App\Repositories\CartRepository;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartComposer
{
    protected $cartRepository;
    protected $cartService;

    public function __construct(CartRepository $cartRepository, CartService $cartService)
    {
        $this->cartRepository = $cartRepository;
        $this->cartService = $cartService;
    }

    public function compose(View $view)
    {
        $cartTotalQuantity = 0;

        // Chỉ tính giỏ hàng nếu user đăng nhập & không phải admin
        if (Auth::check() && !Auth::user()->isAdmin()) {
            $carts = $this->cartRepository->findByCondition([
                ['customer_id', '=', Auth::id()],
            ], true);

            if ($carts && count($carts)) {
                $cartTotalQuantity = $this->cartService->getTotalQuantity($carts);
            }
        }

        // Gửi biến sang tất cả view
        $view->with('cartTotalQuantity', $cartTotalQuantity);
    }
}
