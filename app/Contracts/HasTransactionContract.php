<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasTransactionContract
{
    public function transactions(): MorphMany;
}
