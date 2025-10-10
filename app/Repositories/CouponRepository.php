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



    public function getActiveCoupons()
    {
        return $this->model->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();
    }

    public function incrementUsage($id)
    {
        return $this->model->where('id', $id)->increment('used_count');
    }
}
