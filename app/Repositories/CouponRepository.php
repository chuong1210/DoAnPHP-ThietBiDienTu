<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Repositories\Interfaces\CouponRepositoryInterface;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{
    public function __construct(Coupon $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

    public function findByCode($code)
    {
        return $this->model->where('code', $code)
            ->active()
            ->first();
    }
}
