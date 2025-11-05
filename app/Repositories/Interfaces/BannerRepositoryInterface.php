<?php

namespace App\Repositories\Interfaces;

interface BannerRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveBanners();
}