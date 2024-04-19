<?php

namespace App\Casts;

use App\ValueObject\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

final class MoneyCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): Money
    {
        if ($attributes[$key] === null) {
            return new Money(0);
        }

        return new Money($attributes[$key]);
    }

    public function set($model, string $key, $value, array $attributes): array
    {
        return [
            $key => $value instanceof Money ? $value->getAmountFloat() : $value,
        ];
    }
}
