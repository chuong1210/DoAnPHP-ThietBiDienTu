<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    private $productRepository;

    public function __construct(Order $model, ProductRepository $productRepository)
    {
        $this->model = $model;
        $this->productRepository = $productRepository;
        parent::__construct($this->model);
    }

    /**
     * Lấy đơn hàng theo số đơn
     */
    public function getOrderByNumber($orderNumber)
    {
        return $this->model->with(['items.product', 'user'])
            ->where('order_number', $orderNumber)
            ->first();
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus($id, $status)
    {
        $order = $this->findById($id);
        $oldStatus = $order->status;

        $order->status = $status;
        $order->save();

        // Nếu chuyển sang 'delivered', có thể trigger email hoặc logic khác
        if ($status === 'delivered' && $oldStatus !== 'delivered') {
            // Logic gửi email xác nhận nhận hàng (nếu cần)
        }

        return $order;
    }

    /**
     * Cập nhật trạng thái thanh toán
     */
    public function updatePaymentStatus($id, $status)
    {
        $order = $this->findById($id);
        $order->payment_status = $status;
        $order->save();

        return $order;
    }

    /**
     * Thống kê doanh thu theo khoảng thời gian
     */
    public function getRevenueByDateRange($startDate, $endDate)
    {
        return $this->model->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'delivered')
            ->where('payment_status', 'paid')
            ->sum('total');
    }

    /**
     * Đếm số đơn hàng theo trạng thái
     */
    public function getOrderCountByStatus($status = null)
    {
        if ($status) {
            return $this->model->where('status', $status)->count();
        }

        return $this->model->count();
    }

    /**
     * Lấy danh sách đơn hàng của user (paginated, filter status)
     */
    public function getUserOrders($userId, $status = null, $perPage = 10)
    {
        $query = $this->model->with(['items', 'user'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->paginate($perPage);
    }

    /**
     * Hủy đơn hàng (chỉ pending/confirmed)
     */
    public function cancelOrder($orderId, $reason = null)
    {
        DB::beginTransaction();
        try {
            $order = $this->findById($orderId);

            // Kiểm tra quyền và trạng thái
            if (Auth::id() !== $order->user_id) {
                throw new \Exception('Bạn không có quyền hủy đơn hàng này.');
            }

            if (!in_array($order->status, ['pending', 'confirmed'])) {
                throw new \Exception('Không thể hủy đơn hàng ở trạng thái hiện tại.');
            }

            // Cập nhật trạng thái
            $order->status = 'cancelled';
            $order->note = ($order->note ? $order->note . ' | ' : '') . 'Hủy bởi khách: ' . ($reason ?? 'Không có lý do');
            $order->save();

            // Hoàn lại số lượng sản phẩm vào kho
            foreach ($order->items as $item) {
                $this->productRepository->increaseQuantity($item->product_id, $item->quantity);
            }

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
