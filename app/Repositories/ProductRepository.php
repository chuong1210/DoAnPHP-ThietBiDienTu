<?php

// ==========================================
// PRODUCT REPOSITORY
// ==========================================
namespace App\Repositories;

use App\Models\Category;
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
    public function searchProducts($keyword = null, $filters = [])
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
        // Filter by category (bao gồm cả danh mục con)
        if (!empty($filters['category_id'])) {
            $categoryId = $filters['category_id'];

            // Lấy tất cả ID của danh mục con (và cả chính nó)
            $categoryIds = Category::where('id', $categoryId)
                ->orWhere('parent_id', $categoryId)
                ->pluck('id')
                ->toArray();

            // Nếu có danh mục con cấp sâu hơn (nếu bạn hỗ trợ đa cấp)
            // Dùng recursive hoặc closure table nếu cần, nhưng tạm thời giả sử 2 cấp
            $childIds = Category::whereIn('parent_id', $categoryIds)->pluck('id')->toArray();
            $categoryIds = array_merge($categoryIds, $childIds);

            $query->whereIn('category_id', $categoryIds);
        }

        // Filter by brand
        if (!empty($filters['brand_id'])) {
            $query->where('brand_id', $filters['brand_id']);
        }

        // Filter by price range
        // FIX: Xét cả sale_price
        if (!empty($filters['price_from'])) {
            $priceFrom = (int) $filters['price_from'];
            $query->where(function ($q) use ($priceFrom) {
                $q->where(function ($sub) use ($priceFrom) {
                    // Nếu có sale_price thì check sale_price
                    $sub->whereNotNull('sale_price')
                        ->where('sale_price', '>=', $priceFrom);
                })->orWhere(function ($sub) use ($priceFrom) {
                    // Nếu không có sale_price thì check price
                    $sub->whereNull('sale_price')
                        ->where('price', '>=', $priceFrom);
                });
            });
        }

        if (!empty($filters['price_to'])) {
            $priceTo = (int) $filters['price_to'];
            $query->where(function ($q) use ($priceTo) {
                $q->where(function ($sub) use ($priceTo) {
                    $sub->whereNotNull('sale_price')
                        ->where('sale_price', '<=', $priceTo);
                })->orWhere(function ($sub) use ($priceTo) {
                    $sub->whereNull('sale_price')
                        ->where('price', '<=', $priceTo);
                });
            });
        }

        // Sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'DESC';

        // FIX: Sort theo price cũng xét sale_price
        if ($sortBy === 'price') {
            $query->orderByRaw('COALESCE(sale_price, price) ' . $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        // DEBUG: Uncomment để xem SQL thực tế

        // Pagination
        $perPage = $filters['per_page'] ?? 20;
        return $query->paginate($perPage)->withQueryString();
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

    public function getRelatedProducts($categoryId, $excludeId, $limit = 8)
    {
        return $this->model
            ->where('category_id', $categoryId)
            ->where('id', '!=', $excludeId)
            ->active()
            ->inStock()
            ->limit($limit)
            ->get();
    }
    public function getProductBySlug($slug)
    {
        return $this->model
            ->with(['category', 'brand', 'reviews.user'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();
    }


    public function getProductsByCategorySlug($slug, $perPage = 20)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = $this->model
            ->with(['category', 'brand'])
            ->where('category_id', $category->id)
            ->where('status', 'active')
            ->where('quantity', '>', 0)
            ->paginate($perPage);

        return [
            'category' => $category,
            'products' => $products
        ];
    }
}
