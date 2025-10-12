<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface BrandRepositoryInterface extends BaseRepositoryInterface
{

    public function getActiveBrands();

    public function getActiveBrandsPaginated($perPage = 20);
}
