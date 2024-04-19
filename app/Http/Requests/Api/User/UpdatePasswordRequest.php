<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\DataTransfer\User\UpdatePasswordDTO;

final class UpdatePasswordRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "old_password" => "required|string",
            "new_password" => "required|confirmed:new_password_confirmation"
        ];
    }

    public function getDTO(): UpdatePasswordDTO
    {
        return new UpdatePasswordDTO(
          $this->string("old_password"),
          $this->string("new_password"),
        );
    }
}
