<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

class BrandController extends Controller
{
    protected $brandRepository;
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(
        BrandRepository $brandRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
    ) {
        $this->brandRepository = $brandRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index($slug)
    {
        // Lấy brand theo slug sử dụng repository
        $brand = $this->brandRepository->findByCondition(
            [['slug', '=', $slug]],
            false,
            []
        );

        if (!$brand || !$brand->is_active) {
            abort(404);
        }

        // Lấy sản phẩm theo brand sử dụng repository
        $products = $this->productRepository->getProductsByBrand($brand->id, 12);

        $categories = $this->categoryRepository->getCategoriesWithChildren();
        return view('client.brand.index', compact('brand', 'products', 'categories'));
    }
}
