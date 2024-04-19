<?php

namespace App\Traits;


use App\Models\Finance\Withdraw;

trait HasWithdraws
{
    public function withdraws(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Withdraw::class, "entity");
    }
}
