<?php

namespace App\Http\Requests\Admin\Games;

use App\Http\Requests\BaseRequest;
use App\DataTransfer\Admin\Games\GameDTO;
use Illuminate\Contracts\Validation\ValidationRule;

final class CreateGameRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name"         => "required|string",
            "description"  => "required",
            "game_visible" => "sometimes|required",
            "design"       => "required|image"
        ];
    }

    public function getDTO(): GameDTO
    {
        return new GameDTO(
            $this->str("name"),
            $this->str("description"),
            $this->has("game_visible"),
            $this->file("design")
        );
    }
}
