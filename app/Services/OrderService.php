<?php


// ==========================================
// ORDER SERVICE
// ==========================================
namespace App\Services;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\OrderServiceInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService implements OrderServiceInterface
{
    protected $orderRepository;
    protected $cartRepository;
    protected $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function createOrder($userId, $data)
    {
        DB::beginTransaction();
        try {
            // Lấy giỏ hàng
            $cart = $this->cartRepository->getCartByUser($userId);

            if (!$cart || $cart->items->isEmpty()) {
                throw new Exception('Giỏ hàng trống');
            }

            // Tính tổng tiền
            $subtotal = $cart->total;
            $shippingFee = $data['shipping_fee'] ?? 0;
            $discount = $data['discount'] ?? 0;
            $total = $subtotal + $shippingFee - $discount;

            // Tạo đơn hàng
            $order = $this->orderRepository->create([
                'user_id' => $userId,
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $data['customer_email'] ?? null,
                'shipping_address' => $data['shipping_address'],
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => $data['payment_method'],
                'note' => $data['note'] ?? null,
            ]);

            // Tạo order items và trừ số lượng sản phẩm
            foreach ($cart->items as $item) {
                $product = $item->product;

                // Kiểm tra số lượng
                if ($product->quantity < $item->quantity) {
                    throw new Exception("Sản phẩm {$product->name} không đủ số lượng");
                }

                // Tạo order item
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $product->name,
                    'product_image' => $product->image,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);

                // Trừ số lượng sản phẩm và tăng sold_count
                $product->decrement('quantity', $item->quantity);
                $product->increment('sold_count', $item->quantity);
            }

            // Xóa giỏ hàng
            $this->cartRepository->clearCart($userId);

            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getOrdersByUser($userId)
    {
        return $this->orderRepository->getOrdersByUser($userId);
    }

    public function updateOrderStatus($orderId, $status)
    {
        return $this->orderRepository->update($orderId, ['status' => $status]);
    }

    public function cancelOrder($orderId)
    {
        DB::beginTransaction();
        try {
            $order = $this->orderRepository->findById($orderId, ['*'], ['items']);

            if (!$order->canCancel()) {
                throw new Exception('Không thể hủy đơn hàng này');
            }

            // Hoàn lại số lượng sản phẩm
            foreach ($order->items as $item) {
                $this->productRepository->model
                    ->where('id', $item->product_id)
                    ->increment('quantity', $item->quantity);
            }

            // Cập nhật trạng thái
            $this->orderRepository->update($orderId, ['status' => 'cancelled']);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
