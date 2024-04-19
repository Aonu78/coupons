<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use App\Enum\Users\UserType;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use App\DataTransfer\User\CreateUserDTO;

final class RegisterRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"         => "required|string|min:1",
            "email"        => ["required", "email", Rule::unique(User::class, 'email')->whereNull('deleted_at')],
            "phone_number" => ["sometimes", "required", "string", "nullable"],
            'password'     => "required|string|confirmed",
            'invite_code'  => "sometimes|required|nullable|string"
        ];
    }

    public function getDTO(): CreateUserDTO
    {
        return new CreateUserDTO(
            $this->string('name'),
            $this->string('email'),
            $this->string('password'),
            UserType::USER,
            $this->string('phone_number') ?? null,
            $this->string('invite_code', null)
        );
    }
}
