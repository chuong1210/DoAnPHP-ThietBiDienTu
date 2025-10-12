<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\ClientController;
use App\Repositories\BannerRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

class HomeController extends ClientController
{
    protected $productRepository;
    protected $categoryRepository;
    protected $brandRepository;
    protected $bannerRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        BrandRepository $brandRepository,
        BannerRepository $bannerRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->bannerRepository = $bannerRepository;

        parent::__construct();
    }

    public function index()
    {
        // Lấy categories cho sidebar sử dụng repository
        $categories = $this->categoryRepository->getSidebarCategories();

        // Banners sử dụng repository
        $banners = $this->bannerRepository->getActiveBanners();

        // Sản phẩm nổi bật sử dụng repository
        $featuredProducts = $this->productRepository->getFeaturedProducts(8);

        // Sản phẩm mới sử dụng repository
        $newProducts = $this->productRepository->getNewProducts(12);

        // Brands sử dụng repository
        $brands = $this->brandRepository->getActiveBrands();

        return view('client.home.index', compact(
            'categories',
            'banners',
            'featuredProducts',
            'newProducts',
            'brands'
        ));
    }
}
