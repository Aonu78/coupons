<?php

namespace App\DataTransfer\Coupons;

use Carbon\Carbon;

final class UpdateCouponDTO
{
    public function __construct(
        public readonly string $name,
        public readonly float $price,
        public readonly string $saleStartDate,
        public readonly string $saleEndDate,
        public readonly string $usageStartDate,
        public readonly string $usageEndDate,
        public readonly ?string $icon = null,
        public readonly bool $rebuyible = true,
        public readonly ?int $couponsAvailable = null,
        public readonly ?string $description = null,
        public readonly ?string $gameId = null
    ) {}

    public function hasIcon(): bool
    {
        return !empty($this->icon);
    }

    public function hasGame(): bool
    {
        return !empty($this->gameId);
    }
    /**
     * @throws \Exception
     */
    public function convertIconToFileContent(): string
    {
        $content = base64_decode($this->icon);

        if (!$content) {
            throw new \Exception("Failed to convert icon.");
        }

        return $content;
    }
}
