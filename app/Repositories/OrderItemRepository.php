<?php
// ==========================================
// CATEGORY REPOSITORY
// ==========================================
namespace App\Repositories;

use App\Models\Category;
use App\Models\OrderItem;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\OrderItemRepositoryInterface;

class OrderItemRepository extends BaseRepository implements OrderItemRepositoryInterface
{
    public function __construct(OrderItem $model)
    {
        parent::__construct($model);
    }

    public function createBatch($items)
    {
        return $this->model->insert($items);
    }
}
