<?php

// ==========================================
// BRAND REPOSITORY
// ==========================================
namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Interfaces\BrandRepositoryInterface;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function __construct(Brand $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

    public function getActiveBrands()
    {
        $condition = [
            ['is_active', '=', true]
        ];
        return $this->findByCondition($condition, true, [], ['name', 'ASC']); // flag=true để lấy tất cả
    }

    // Hoặc dùng pagination nếu cần phân trang
    public function getActiveBrandsPaginated($perPage = 20)
    {
        $condition = [
            'where' => [
                ['is_active', '=', true]
            ]
        ];
        return $this->pagination(['*'], $condition, $perPage);
    }
}
