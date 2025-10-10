<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface CouponRepositoryInterface extends BaseRepositoryInterface
{
    public function findByCode($code);
    public function getActiveCoupons();

    public function incrementUsage($id);
}
