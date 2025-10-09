<?php

namespace App\Services\Interfaces;

interface CouponServiceInterface
{
    public function validateCoupon($code, $orderTotal);
    public function applyCoupon($code, $orderTotal);
}
