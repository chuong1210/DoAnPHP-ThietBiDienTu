<?php

// ==========================================
// BRAND REPOSITORY
// ==========================================
namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Interfaces\BrandRepositoryInterface;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function __construct(Brand $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
