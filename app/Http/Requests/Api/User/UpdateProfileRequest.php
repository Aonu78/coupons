<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;
use App\DataTransfer\User\UpdateProfileDTO;
use Illuminate\Contracts\Validation\ValidationRule;

final class UpdateProfileRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name"         => "required|string|min:1",
            "email"        => ["required", "string", Rule::unique(User::class, 'email')->ignore(Auth::id())],
            "phone_number" => "required|string",
            "avatar"       => "sometimes|string|nullable"
        ];
    }

    public function getDTO(): UpdateProfileDTO
    {
        return new UpdateProfileDTO(
            $this->string("name"),
            $this->string("email"),
            $this->string("phone_number"),
            $this->string("avatar")
        );
    }
}
