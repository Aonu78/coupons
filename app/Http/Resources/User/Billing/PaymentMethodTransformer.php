<?php

namespace App\Http\Resources\User\Billing;

use Stripe\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PaymentMethod */
class PaymentMethodTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "payment_method_id"             => $this->id,
            "payment_method_card_brand"     => $this->card->brand,
            "payment_method_card_last4"     => $this->card->last4,
            "payment_method_card_exp_month" => $this->card->exp_month,
            "payment_method_card_exp_year"  => $this->card->exp_year,
        ];
    }
}
