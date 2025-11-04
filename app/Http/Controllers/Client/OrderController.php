<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $productRepository;

    public function __construct(
        OrderRepository $orderRepository,
        ProductRepository $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Hiển thị danh sách đơn hàng của user
     * GET /client/my-orders
     */
    public function index(Request $request, CategoryRepository $categoryRepository)
    {
        $status = $request->get('status'); // Filter theo status
        $userId = Auth::id();
        $orders = $this->orderRepository->getUserOrders(
            $userId,
            $status,
            10
        );
        // Đếm số lượng từng trạng thái
        $statusCounts = [
            'all'        => $this->orderRepository->countUserOrders($userId),
            'pending'    => $this->orderRepository->countUserOrders($userId, 'pending'),
            'confirmed'  => $this->orderRepository->countUserOrders($userId, 'confirmed'),
            'shipping'   => $this->orderRepository->countUserOrders($userId, 'shipping'),
            'delivered'  => $this->orderRepository->countUserOrders($userId, 'delivered'),
            'cancelled'  => $this->orderRepository->countUserOrders($userId, 'cancelled'),
        ];
        $categories = $categoryRepository->getSidebarCategories(); // Pass categories for layout sidebar


        return view('client.orders.index', compact('orders', 'status', 'categories', 'statusCounts'));
    }

    /**
     * Hiển thị chi tiết đơn hàng
     * GET /client/my-orders/{id}
     */
    public function show($id)
    {
        $order = $this->orderRepository->findById($id, ['*'], ['items', 'user']);

        // Kiểm tra quyền sở hữu
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        return view('client.orders.detail', compact('order'));
    }

    /**
     * Hủy đơn hàng
     * POST /client/my-orders/{id}/cancel
     */
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'nullable|string|max:500',
        ]);

        try {
            $this->orderRepository->cancelOrder($id, $request->cancel_reason);

            return redirect()->route('client.my-orders.index')
                ->with('success', 'Đã hủy đơn hàng thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi hủy đơn hàng: ' . $e->getMessage());
        }
    }
}
