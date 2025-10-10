<?php

// ==========================================
// CART SERVICE
// ==========================================
namespace App\Services;

use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\CartServiceInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class CartService implements CartServiceInterface
{
    protected $cartRepository;
    protected $productRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function addToCart($userId, $productId, $quantity)
    {
        DB::beginTransaction();
        try {
            // Kiểm tra sản phẩm
            $product = $this->productRepository->findById($productId);

            if ($product->quantity < $quantity) {
                throw new Exception('Sản phẩm không đủ số lượng');
            }

            // Lấy hoặc tạo cart
            $cart = $this->cartRepository->getCartByUser($userId);

            if (!$cart) {
                $cart = $this->cartRepository->create(['user_id' => $userId]);
            }

            // Kiểm tra xem sản phẩm đã có trong giỏ chưa
            $cartItem = $cart->items()->where('product_id', $productId)->first();

            if ($cartItem) {
                // Cập nhật số lượng
                $newQuantity = $cartItem->quantity + $quantity;

                if ($product->quantity < $newQuantity) {
                    throw new Exception('Sản phẩm không đủ số lượng');
                }

                $cartItem->update([
                    'quantity' => $newQuantity,
                    'price' => $product->final_price
                ]);
            } else {
                // Thêm mới
                $cart->items()->create([
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->final_price
                ]);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateCart($userId, $productId, $quantity)
    {
        DB::beginTransaction();
        try {
            $cart = $this->cartRepository->getCartByUser($userId);

            if (!$cart) {
                throw new Exception('Giỏ hàng không tồn tại');
            }

            $cartItem = $cart->items()->where('product_id', $productId)->first();

            if (!$cartItem) {
                throw new Exception('Sản phẩm không có trong giỏ hàng');
            }

            // Kiểm tra số lượng
            $product = $this->productRepository->findById($productId);

            if ($product->quantity < $quantity) {
                throw new Exception('Sản phẩm không đủ số lượng');
            }

            $cartItem->update(['quantity' => $quantity]);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function removeFromCart($userId, $productId)
    {
        DB::beginTransaction();
        try {
            $cart = $this->cartRepository->getCartByUser($userId);

            if ($cart) {
                $cart->items()->where('product_id', $productId)->delete();
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function getTotalQuantity($carts)
    {
        $totalQuantity = 0;
        foreach ($carts as $cart) {
            $totalQuantity += $cart->quantity;
        }
        return $totalQuantity;
    }

    public function getCart($userId)
    {
        return $this->cartRepository->getCartByUser($userId);
    }

    public function clearCart($userId)
    {
        return $this->cartRepository->clearCart($userId);
    }
}
