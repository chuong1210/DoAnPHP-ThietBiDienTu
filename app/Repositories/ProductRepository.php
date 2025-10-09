<?php

// ==========================================
// PRODUCT REPOSITORY
// ==========================================
namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

    public function searchProducts($keyword, $perPage = 20)
    {
        return $this->model->search($keyword)
            ->with(['category', 'brand'])
            ->active()
            ->paginate($perPage);
    }

    public function getProductsByCategory($categoryId, $perPage = 20)
    {
        return $this->model->where('category_id', $categoryId)
            ->with(['brand', 'reviews'])
            ->active()
            ->inStock()
            ->paginate($perPage);
    }

    public function getProductsByBrand($brandId, $perPage = 20)
    {
        return $this->model->where('brand_id', $brandId)
            ->with(['category', 'reviews'])
            ->active()
            ->inStock()
            ->paginate($perPage);
    }

    public function getFeaturedProducts($limit = 10)
    {
        return $this->model->featured()
            ->active()
            ->inStock()
            ->with(['category', 'brand'])
            ->limit($limit)
            ->get();
    }
}
