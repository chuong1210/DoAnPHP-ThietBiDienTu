<?php

namespace App\Repositories;

use App\Models\Banner;
use App\Repositories\Interfaces\BannerRepositoryInterface;

class BannerRepository extends BaseRepository implements BannerRepositoryInterface
{
    public function __construct(Banner $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

    public function getActiveBanners()
    {
        return $this->model->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
