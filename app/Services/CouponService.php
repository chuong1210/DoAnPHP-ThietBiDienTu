<?php


// ==========================================
// COUPON SERVICE
// ==========================================
namespace App\Services;

use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Services\Interfaces\CouponServiceInterface;
use Exception;

class CouponService implements CouponServiceInterface
{
    protected $couponRepository;

    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function validateCoupon($code, $orderTotal)
    {
        $coupon = $this->couponRepository->findByCode($code);

        if (!$coupon) {
            throw new Exception('Mã giảm giá không tồn tại');
        }

        if (!$coupon->isValid()) {
            throw new Exception('Mã giảm giá không hợp lệ hoặc đã hết hạn');
        }

        if ($orderTotal < $coupon->min_order) {
            throw new Exception("Đơn hàng phải có giá trị tối thiểu " . number_format($coupon->min_order) . "đ");
        }

        return $coupon;
    }

    public function applyCoupon($code, $orderTotal)
    {
        $coupon = $this->validateCoupon($code, $orderTotal);
        $discount = $coupon->calculateDiscount($orderTotal);

        return [
            'coupon' => $coupon,
            'discount' => $discount
        ];
    }
}
