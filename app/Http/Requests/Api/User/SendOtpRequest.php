<?php

namespace App\Http\Requests\Api\User;

use App\DataTransfer\User\SendOtpDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class SendOtpRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "login" => "required|string"
        ];
    }

    public function getDTO(): SendOtpDTO
    {
        return new SendOtpDTO($this->str("login"));
    }
}
