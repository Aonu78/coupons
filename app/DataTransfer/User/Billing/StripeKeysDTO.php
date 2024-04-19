<?php

namespace App\DataTransfer\User\Billing;

final class StripeKeysDTO
{
    public function __construct()
    {
        $this->stripeKey = config('services.stripe.key');
        $this->stripeSecret = config('services.stripe.secret');
    }
}
