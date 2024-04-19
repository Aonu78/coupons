<?php

namespace App\DataTransfer\Settings;

final class UpdateSettingsDTO
{
    public function __construct(
        public readonly bool $isPaymentLive,
        public readonly string $testStripeKey,
        public readonly string $testStripeSecret,
        public readonly string $liveStripeKey,
        public readonly string $liveStripeSecret,
        public readonly int $dailyTokens,
    ) {}

    public function getArray(): array
    {
        return [
            "is_payment_live"    => $this->isPaymentLive,
            "test_stripe_key"    => $this->testStripeKey,
            "test_stripe_secret" => $this->testStripeSecret,
            "live_stripe_key"    => $this->liveStripeKey,
            "live_stripe_secret" => $this->liveStripeSecret,
            "daily_tokens" => $this->dailyTokens,
        ];
    }
}
