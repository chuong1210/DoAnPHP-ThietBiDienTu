<?php

namespace App\Repositories\Interfaces;

/**
 * Interface ProductRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function searchProducts($keyword, $perPage = 20);
    public function getProductsByCategory($categoryId, $perPage = 20);
    public function getProductsByBrand($brandId, $perPage = 20);
    public function getFeaturedProducts($limit = 10);
}
