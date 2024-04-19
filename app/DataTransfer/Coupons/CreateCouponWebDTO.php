<?php

namespace App\DataTransfer\Coupons;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

final class CreateCouponWebDTO
{
    public function __construct(
        public readonly string $name,
        public readonly float $price,
        public readonly string $saleStartDate,
        public readonly string $saleEndDate,
        public readonly string $usageStartDate,
        public readonly string $usageEndDate,
        public readonly UploadedFile $icon,
        public readonly bool $rebuyible = true,
        public readonly ?int $couponsAvailable = null,
        public readonly ?string $description = null,
        public readonly ?string $gameId = null
    ) {}

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

    public function hasGame(): bool
    {
        return !empty($this->gameId);
    }
}
