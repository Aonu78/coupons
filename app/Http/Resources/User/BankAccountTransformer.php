<?php

namespace App\Http\Resources\User;

use App\Models\UserBank;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin UserBank */
final class BankAccountTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "bank_id"               => $this->bank_uuid,
            "account_number"        => $this->account_number,
            "account_name"          => $this->account_name,
            "account_name_furigana" => $this->account_name_furigana,
            "bank_name"             => $this->bank_name,
            "branch_number"         => $this->branch_number,
            "deposit_type"          => $this->deposit_type->value,
            "last_update_at"        => $this->updated_at
        ];
    }
}
