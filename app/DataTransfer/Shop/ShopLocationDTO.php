<?php

namespace App\DataTransfer\Shop;

final class ShopLocationDTO
{
    public function __construct(
        public readonly string $postalCode,
        public readonly string $prefecture,
        public readonly string $address,
        public readonly ?string $buildingNumber = null,
    ) {}
}
