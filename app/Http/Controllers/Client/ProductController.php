<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ReviewRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    protected $productRepository;
    protected $productService;
    protected $categoryRepository;
    protected $categoryService;
    protected $brandRepository;
    protected $brandService;
    protected $reviewRepository;

    public function __construct(
        ProductRepository $productRepository,
        ProductService $productService,
        CategoryRepository $categoryRepository,
        BrandRepository $brandRepository,
        ReviewRepository $reviewRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->reviewRepository = $reviewRepository;
    }
    /**
     * Danh sách sản phẩm với filter
     */
    public function index(Request $request)
    {
        // Lấy categories cho sidebar
        $categories = $this->categoryRepository->getCategoriesWithChildren();

        // $brands = $this->brandRepository->getActiveBrands();
        $brands = Brand::where('is_active', 1)->orderBy('name')->get();


        // Xử lý category_id để bao gồm cả subcategories
        $categoryId = $request->get('category_id');
        $categoryIds = [];

        if ($categoryId) {
            // Tìm category và lấy tất cả con cháu
            $selectedCategory = $categories->find($categoryId);
            if ($selectedCategory) {
                $categoryIds = $this->getAllChildIds($selectedCategory);
                $categoryIds[] = $categoryId; // Thêm chính nó
            }
        }

        $products = $this->productRepository->searchProducts(
            $request->get('keyword'),  // keyword tìm kiếm (nếu có)
            [
                'category_id' => $categoryIds ? $categoryIds : null,  // Truyền mảng ids hoặc null
                'brand_id'    => $request->get('brand_id'),
                'price_from'  => $request->get('price_from'),
                'price_to'    => $request->get('price_to'),
                'sort_by'     => $request->get('sort', 'created_at'),
                'sort_order'  => $request->get('order', 'DESC'),
                'per_page'    => $request->get('per_page', 20),
            ]
        );

        return view('client.product.index', compact(
            'products',
            'categories',
            'brands'
        ));
    }

    // Helper method để lấy tất cả child ids recursively
    private function getAllChildIds($category)
    {
        $ids = [];

        if ($category->children) {
            foreach ($category->children as $child) {
                $ids[] = $child->id;
                $ids = array_merge($ids, $this->getAllChildIds($child));
            }
        }

        return $ids;
    }
    /**
     * Chi tiết sản phẩm
     */

    public function show($slug)
    {
        // Lấy sản phẩm theo slug qua ProductService/Repository
        $product = $this->productRepository->getProductBySlug($slug);

        // Tăng lượt xem
        $this->productRepository->incrementViewCount($product->id);

        // Lấy sản phẩm liên quan
        $relatedProducts = $this->productRepository->getRelatedProducts(
            $product->category_id,
            $product->id,
            8
        );

        // Lấy đánh giá đã duyệt (paginated)
        $reviews = $this->reviewRepository->getApprovedReviewsByProduct($product->id, 5);

        // Tính điểm trung bình
        $averageRating = $this->reviewRepository->getAverageRating($product->id);

        // Tính discount percent nếu có sale_price
        $discountPercent = $product->sale_price ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;

        // Categories cho sidebar
        $categories = $this->categoryRepository->getCategoriesWithChildren();

        // === PHẦN THÊM MỚI QUAN TRỌNG ===
        $userHasReviewed = false;
        $canUserReview = false;


        if (Auth::check()) {
            // Kiểm tra xem user đã từng review sản phẩm này chưa (bất kể status)
            $userHasReviewed = $this->reviewRepository->hasUserReviewedProduct($product->id, Auth::id());

            // Kiểm tra xem user có đủ điều kiện để viết review mới không
            // (đã mua, đã giao hàng, và chưa review)
            if (!$userHasReviewed) {
                $canUserReview = DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.user_id', Auth::id())
                    ->where('order_items.product_id', $product->id)
                    ->where('orders.status', 'delivered')
                    ->exists();
            }
        }

        return view('client.product.show', compact(
            'product',
            'relatedProducts',
            'categories',
            'reviews',
            'averageRating',
            'discountPercent',
            'userHasReviewed', // <-- Biến mới
            'canUserReview'    // <-- Biến mới
        ));
    }

    /**
     * Tìm kiếm sản phẩm
     */
    public function search(Request $request)
    {
        $keyword = $request->get('q');

        $filters = [
            'category_id' => $request->get('category_id'),
            'brand_id'    => $request->get('brand_id'),
            'price_from'  => $request->get('price_from'),
            'price_to'    => $request->get('price_to'),
            'sort_by'     => $request->get('sort', 'created_at'),
            'sort_order'  => $request->get('order', 'DESC'),
            'per_page'    => $request->get('per_page', 20),
        ];

        $products = $this->productRepository->searchProducts($keyword, $filters);
        $categories = $this->categoryRepository->getSidebarCategories();

        return view('client.product.search', compact(
            'products',
            'keyword',
            'categories'
        ));
    }

    /**
     * Sản phẩm theo category
     */
    public function category($slug)
    {
        // Lấy category + products qua service
        $data = $this->productRepository->getProductsByCategorySlug($slug, 20);


        // Lấy categories cho sidebar
        $categories = $this->categoryRepository->getSidebarCategories();

        return view('client.product.category', [
            'category'   => $data['category'],
            'products'   => $data['products'],
            'categories' => $categories
        ]);
    }

    public function all(Request $request)
    {
        // Lấy categories cho sidebar
        $categories = $this->categoryRepository->getCategoriesWithChildren();

        // Lấy brands cho filter
        // $brands = $this->brandRepository->getActiveBrands();
        $brands = Brand::where('is_active', 1)->orderBy('name')->get();


        // Xử lý sort và order
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order');

        if (!$order) {
            $order = match ($sort) {
                'price' => 'ASC',
                'name' => 'ASC',
                'sold_count' => 'DESC',
                default => 'DESC'
            };
        }

        // Xây dựng filters
        $filters = [
            'sort_by'     => $sort,
            'sort_order'  => $order,
            'per_page'    => $request->get('per_page', 20),
        ];

        // Thêm filter nếu có giá trị
        if ($request->filled('category_id')) {
            $filters['category_id'] = $request->get('category_id');
        }

        if ($request->filled('brand_id')) {
            $filters['brand_id'] = $request->get('brand_id');
        }

        if ($request->filled('price_from')) {
            $filters['price_from'] = $request->get('price_from');
        }

        if ($request->filled('price_to')) {
            $filters['price_to'] = $request->get('price_to');
        }

        // Lấy tất cả sản phẩm với filters
        $products = $this->productRepository->searchProducts(
            $request->get('keyword'),  // Cho phép keyword nếu có
            $filters
        );

        $brands = Brand::where('is_active', 1)->orderBy('name')->get();

        return view('client.product.all', compact(
            'products',
            'categories',
            'brands'
        ));
    }
}
