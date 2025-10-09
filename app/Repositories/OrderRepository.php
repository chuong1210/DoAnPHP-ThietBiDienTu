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
}
