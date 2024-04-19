<?php

namespace App\DataTransfer\Shop;

final class ShopContactDTO
{
    public function __construct(
        public readonly string $contactName,
        public readonly string $contactNameFurigana,
        public readonly ?string $contactPhoneNumber = null,
        public readonly ?string $shopUrl = null,
    ) {}
}
