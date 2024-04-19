<?php

namespace App\DataTransfer\Coupons;

final class AssociateWithGameDTO
{
    public function __construct(
        public readonly string $gameId
    ) {}
}
