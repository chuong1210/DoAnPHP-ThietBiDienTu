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

        $brands = $this->brandRepository->getActiveBrands();

        // Gọi service để lấy products (không xử lý DB ở Controller nữa)
        $products = $this->productService->search(
            $request->get('keyword'),  // keyword tìm kiếm (nếu có)
            [
                'category_id' => $request->get('category_id'),
                'brand_id'    => $request->get('brand_id'),
                'price_from'  => $request->get('price_from'),
                'price_to'    => $request->get('price_to'),
                'sort'        => $request->get('sort', 'created_at'),
                'order'       => $request->get('order', 'DESC'),
            ]
        );

        return view('client.product.index', compact(
            'products',
            'categories',
            'brands'
        ));
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

        return view('client.product.show', compact(
            'product',
            'relatedProducts',
            'categories',
            'reviews',
            'averageRating',
            'discountPercent'
        ));
    }

    /**
     * Tìm kiếm sản phẩm
     */
    public function search(Request $request)
    {
        $keyword = $request->get('q');

        $filters = [
            'category_id' => $request->category_id,
            'brand_id'    => $request->brand_id,
            'price_from'  => $request->price_from,
            'price_to'    => $request->price_to,
            'sort_by'     => $request->get('sort', 'created_at'),
            'sort_order'  => $request->get('order', 'DESC'),
            'per_page'    => 20
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


    /**
     * Hiển thị tất cả sản phẩm
     */
    public function all(Request $request)
    {
        // Lấy categories cho sidebar
        $categories = $this->categoryRepository->getCategoriesWithChildren();

        // Lấy brands cho filter
        $brands = $this->brandRepository->getActiveBrands();

        // Lấy tất cả sản phẩm active và in stock, paginated
        $products = $this->productRepository->searchProducts(
            null,  // Không có keyword
            [
                'per_page' => 20,
                'sort_by'  => $request->get('sort', 'created_at'),
                'sort_order' => $request->get('order', 'DESC')
            ]
        );

        return view('client.product.all', compact(
            'products',
            'categories',
            'brands'
        ));
    }
}
