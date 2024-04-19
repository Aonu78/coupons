<?php

namespace App\Http\Requests\Admin\Settings;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\DataTransfer\Settings\UpdateSettingsDTO;

final class SaveRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "live_stripe_key" => "required|string",
            "live_stripe_secret" => "required|string",
            "test_stripe_key" => "required|string",
            "test_stripe_secret" => "required|string",
            "login_tokens" => "required|numeric",
            "is_payment_live" => "sometimes|required",
        ];
    }

    public function getDTO(): UpdateSettingsDTO
    {
        return new UpdateSettingsDTO(
            $this->has("is_payment_live"),
            $this->str("test_stripe_key"),
            $this->str("test_stripe_secret"),
            $this->str("live_stripe_key"),
            $this->str("live_stripe_secret"),
            $this->integer("login_tokens"),
        );
    }
}
