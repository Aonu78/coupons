<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enum\Finance\WalletCurrency;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\InvitedByTransformer;
use App\Http\Resources\User\BankAccountTransformer;
use App\Http\Resources\User\Billing\PaymentMethodTransformer;

/** @mixin User */
class UserTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $this->createOrGetStripeCustomer();

        $cpTokens = $this->getWallet(WalletCurrency::CP_TOKEN)?->wallet_balance?->getAmountString(
        ) ?? $this->cp_token_balance;
        $usdTokens = $this->getWallet(WalletCurrency::USD)?->wallet_balance?->getAmountString() ?? $this->usd_balance;

        $userBank = $this->bank;
        $userInvitedBy = $this->invitedBy;

        return [
            "user_id"                => $this->id,
            "user_name"              => $this->name,
            "user_email"             => $this->email,
            "user_phone_number"      => $this->phone_number,
            "user_avatar"            => $this->avatar,
            "default_payment_method" => new PaymentMethodTransformer($this->defaultPaymentMethod()),
            "user_bank_account"      => is_null($userBank) ? null : new BankAccountTransformer($userBank),
            "user_invite_link"       => route('invite', $this->invite_code),
            "user_invited_by"        => is_null($userInvitedBy) ? null : new InvitedByTransformer($userInvitedBy),
            "wallets"                => [
                "CP_TOKEN" => $cpTokens,
                "USD"      => $usdTokens
            ]
        ];
    }
}
