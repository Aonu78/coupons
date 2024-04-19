<?php

namespace App\Http\Requests\Shop\Coupons;

use App\Models\Game;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use App\DataTransfer\Coupons\AssociateWithGameDTO;
use Illuminate\Contracts\Validation\ValidationRule;

final class AssociateWIthGameRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "game_id" => ["required", Rule::exists(Game::class, "game_uuid")]
        ];
    }

    public function getDTO(): AssociateWithGameDTO
    {
        return new AssociateWithGameDTO($this->string("game_id"));
    }
}
