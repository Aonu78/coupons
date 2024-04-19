<?php

namespace App\Http\Resources\Finance;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Finance\Withdraw;
use App\Enum\Finance\WalletCurrency;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\Billing\PaymentMethodTransformer;

/** @mixin Withdraw */
final class WithdrawTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $user*/
        $user = $this->entity;
        try {
            $paymentMethod = $user->findPaymentMethod($this->withdraw_target);
        } catch (\Exception $e) {
            $paymentMethod = $user->defaultPaymentMethod();
        }

        $wallet = $this->getWallet(WalletCurrency::USD);

        return [
            "withdraw_uuid"        => $this->withdraw_uuid,
            "withdraw_status"      => $this->withdraw_status,
            "withdraw_amount"      => $wallet->wallet_balance->getAmountString(),
//            "withdraw_destination" => new PaymentMethodTransformer($paymentMethod),
            "withdraw_created_at"  => $this->created_at
        ];
    }
}
