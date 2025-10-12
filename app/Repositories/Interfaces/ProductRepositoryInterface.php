<?php

namespace App\Repositories\Interfaces;

/**
 * Interface ProductRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function searchProducts($keyword, $filters = []);
    public function incrementViewCount($id);


    public function getProductsByCategory($categoryId, $perPage = 20);

    public function getNewProducts($limit = 10);
    public function getBestSellingProducts($limit = 10);
    public function decreaseQuantity($id, $quantity);
    public function increaseQuantity($id, $quantity);



    public function getProductsByBrand($brandId, $perPage = 20);
    public function getFeaturedProducts($limit = 10);


    public function getRelatedProducts($categoryId, $excludeId, $limit = 8);
    public function getProductsByCategorySlug($slug, $perPage = 20);
    public function getProductBySlug($slug);
}
