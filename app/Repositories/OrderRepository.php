<?php
// ==========================================
// ORDER REPOSITORY
// ==========================================
namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

    public function getOrdersByUser($userId, $perPage = 20)
    {
        return $this->model->where('user_id', $userId)
            ->with(['items.product'])
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }




    public function getOrderByNumber($orderNumber)
    {
        return $this->model->with(['items.product', 'user'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();
    }

    public function updateStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }

    public function updatePaymentStatus($id, $status)
    {
        return $this->update($id, ['payment_status' => $status]);
    }

    public function getRevenueByDateRange($startDate, $endDate)
    {
        return $this->model->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');
    }

    public function getOrderCountByStatus($status)
    {
        return $this->model->where('status', $status)->count();
    }
}
