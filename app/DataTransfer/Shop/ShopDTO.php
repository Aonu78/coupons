<?php

namespace App\DataTransfer\Shop;

use Exception;

final class ShopDTO
{
    public function __construct(
        public readonly string $shopName,
        public readonly string $shopNameFurigana,
        public readonly ShopContactDTO $shopContact,
        public readonly ShopLocationDTO $shopLocation,
        public readonly ?string $shopPR = null,
        public readonly ?string $shopLogo = null,
    ) {}

    /**
     * @return bool
     */
    public function hasLogo(): bool
    {
        return !empty($this->shopLogo);
    }

    /**
     * @throws Exception
     */
    public function convertLogoToFileContent(): string
    {
        $content = base64_decode($this->shopLogo);

        if (!$content) {
            throw new Exception("Failed to convert shop logo.");
        }

        return $content;
    }
}
