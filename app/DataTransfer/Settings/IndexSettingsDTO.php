<?php

namespace App\DataTransfer\Settings;

use Illuminate\Database\Eloquent\Collection;
use App\DataTransfer\User\Billing\StripeKeysDTO;

final class IndexSettingsDTO
{
    public function __construct(
        public readonly ?bool $isPaymentLive,
        public readonly ?string $testStripeKey,
        public readonly ?string $testStripeSecret,
        public readonly ?string $liveStripeKey,
        public readonly ?string $liveStripeSecret,
        public readonly ?int $loginTokens,
    ) {}

    public static function createFromCollection(Collection $collection)
    {
        $isPaymentLive = $collection->where('setting_key', 'is_payment_live')->first();
        $testStripeKey = $collection->where('setting_key', 'test_stripe_key')->first();
        $testStripeSecret = $collection->where('setting_key', 'test_stripe_secret')->first();
        $liveStripeKey = $collection->where('setting_key', 'live_stripe_key')->first();
        $liveStripeSecret = $collection->where('setting_key', 'live_stripe_secret')->first();
        $loginTokens = $collection->where('setting_key', 'daily_tokens')->first();

        return new self(
            $isPaymentLive?->setting_value,
            $testStripeKey?->setting_value,
            $testStripeSecret?->setting_value,
            $liveStripeKey?->setting_value,
            $liveStripeSecret?->setting_value,
            $loginTokens?->setting_value,
        );
    }

    public function getStripeKeys(): StripeKeysDTO
    {
        if ($this->isPaymentLive) {
            return new StripeKeysDTO($this->liveStripeKey, $this->liveStripeSecret);
        }

        return new StripeKeysDTO($this->testStripeKey, $this->testStripeSecret);
    }
}
