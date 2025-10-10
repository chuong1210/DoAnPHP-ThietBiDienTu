<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Support\Facades\DB;

class ProductService implements ProductServiceInterface
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll($perPage = 20)
    {
        return $this->productRepository->pagination(['*'], [], $perPage, [], ['category', 'brand']);
    }

    public function search($keyword, $filters = [])
    {
        $query = $this->productRepository->model->newQuery();

        // Tìm kiếm theo keyword
        if (!empty($keyword)) {
            $query->search($keyword);
        }

        // Lọc theo category
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Lọc theo brand
        if (!empty($filters['brand_id'])) {
            $query->where('brand_id', $filters['brand_id']);
        }

        // Lọc theo giá
        if (!empty($filters['price_from'])) {
            $query->where('price', '>=', $filters['price_from']);
        }
        if (!empty($filters['price_to'])) {
            $query->where('price', '<=', $filters['price_to']);
        }

        // Sắp xếp
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price_asc':
                    $query->orderBy('price', 'ASC');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'DESC');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'DESC');
                    break;
                case 'popular':
                    $query->orderBy('view_count', 'DESC');
                    break;
            }
        }

        return $query->active()->with(['category', 'brand'])->paginate($filters['per_page'] ?? 20);
    }

    public function getById($id)
    {
        // Tăng view count
        DB::table('products')->where('id', $id)->increment('view_count');

        return $this->productRepository->findById($id, ['*'], ['category', 'brand', 'reviews.user']);
    }
}
