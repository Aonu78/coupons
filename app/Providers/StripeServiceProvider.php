<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Settings\SettingService;

class StripeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /** @var SettingService $settingsService */
        $settingsService = resolve(SettingService::class);
        $stripeKeys = $settingsService->all()->getStripeKeys();

        config()->set('cashier.key', $stripeKeys->stripeKey);
        config()->set('cashier.secret', $stripeKeys->stripeSecret);
    }
}
