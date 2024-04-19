<?php

namespace App\DataTransfer\Http;

use JsonSerializable;

final class ResponseDTO
{
    public function __construct(
        public readonly JsonSerializable|array|null $data = null,
        public readonly string $message = "",
        public readonly array $meta = []
    ) {}
}
