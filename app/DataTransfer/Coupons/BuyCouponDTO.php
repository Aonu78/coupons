<?php

namespace App\DataTransfer\Coupons;

final class BuyCouponDTO
{
    public function __construct(
        public readonly int $couponId,
        public readonly string $paymentMethod
    ) {}
}
