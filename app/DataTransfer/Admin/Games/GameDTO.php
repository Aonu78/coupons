<?php

namespace App\DataTransfer\Admin\Games;

use Illuminate\Http\UploadedFile;

final class GameDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly bool $isVisible,
        public readonly ?UploadedFile $cover = null
    ) {}
}
