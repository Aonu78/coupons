<?php

namespace App\Http\Resources\Finance;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Transaction */
final class TransactionTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "transaction_id"          => $this->transaction_uuid,
            "transaction_amount"      => $this->transaction_amount->getAmountString(),
            "transaction_operation"   => $this->transaction_operation->value,
            "transaction_description" => $this->transaction_description,
            "transaction_currency"    => $this->transaction_currency->value,
            "transaction_date"        => $this->created_at
        ];
    }
}
