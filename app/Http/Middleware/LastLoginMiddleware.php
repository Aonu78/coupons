<?php

namespace App\Http\Middleware;

use Closure;
use App\ValueObject\Money;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Enum\Finance\WalletCurrency;
use App\Services\Settings\SettingService;
use App\Constants\TransactionDescriptions;
use App\Services\Finance\TransactionService;
use Symfony\Component\HttpFoundation\Response;
use App\Enum\Finance\Transaction\TransactionType;
use App\Enum\Finance\Transaction\TransactionOperation;

final class LastLoginMiddleware
{
    public function __construct(
        private readonly SettingService $settingService,
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (is_null($user->last_login) || Carbon::parse($user->last_login)->diffInDays(now()) > 0) {
                $user->last_login = now();
                $user->save();

                $tokensToGrant = $this->settingService->find('daily_tokens');
                $cpWallet = $user->getWallet(WalletCurrency::CP_TOKEN);

                if (is_null($cpWallet)) {
                    $cpWallet = $user->createWallet(WalletCurrency::CP_TOKEN);
                }

                $cpWallet->wallet_balance->add(new Money($tokensToGrant->setting_value));
                $cpWallet->save();
            }
        }

        return $next($request);
    }
}
