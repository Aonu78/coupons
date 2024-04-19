<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
final class InvitedUsersTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "user_name" => $this->name,
            "user_email" => $this->email,
            "user_avatar" => $this->avatar,
            "user_registered_at" => $this->created_at,
        ];
    }
}
