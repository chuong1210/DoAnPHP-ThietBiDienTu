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
        return $this->model->with(['category', 'brand'])
            ->where('is_featured', true)
            ->where('status', 'active')
            ->where('quantity', '>', 0)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
    }

    public function getNewProducts($limit = 10)
    {
        return $this->model->with(['category', 'brand'])
            ->where('status', 'active')
            ->where('quantity', '>', 0)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
    }

    public function getBestSellingProducts($limit = 10)
    {
        return $this->model->with(['category', 'brand'])
            ->where('status', 'active')
            ->where('quantity', '>', 0)
            ->orderBy('sold_count', 'DESC')
            ->limit($limit)
            ->get();
    }

    public function searchProducts($keyword, $filters = [])
    {
        $query = $this->model->with(['category', 'brand'])
            ->where('status', 'active')
            ->where('quantity', '>', 0);

        // Search by keyword
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        // Filter by category
        if (isset($filters['category_id']) && !empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Filter by brand
        if (isset($filters['brand_id']) && !empty($filters['brand_id'])) {
            $query->where('brand_id', $filters['brand_id']);
        }

        // Filter by price range
        if (isset($filters['price_from']) && !empty($filters['price_from'])) {
            $query->where('price', '>=', $filters['price_from']);
        }

        if (isset($filters['price_to']) && !empty($filters['price_to'])) {
            $query->where('price', '<=', $filters['price_to']);
        }

        // Sort
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'DESC';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($filters['per_page'] ?? 20);
    }

    public function incrementViewCount($id)
    {
        return $this->model->where('id', $id)->increment('view_count');
    }

    public function decreaseQuantity($id, $quantity)
    {
        return $this->model->where('id', $id)->decrement('quantity', $quantity);
    }

    public function increaseQuantity($id, $quantity)
    {
        return $this->model->where('id', $id)->increment('quantity', $quantity);
    }
}
