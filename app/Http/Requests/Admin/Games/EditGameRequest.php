<?php

namespace App\Http\Requests\Admin\Games;

use App\Http\Requests\BaseRequest;
use App\DataTransfer\Admin\Games\GameDTO;
use Illuminate\Foundation\Http\FormRequest;

final class EditGameRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string",
            "description" => "required",
            "game_visible" => "sometimes|required",
            'game_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Add your validation rules here
            'design' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Add your validation rules here
        ];
    }

    public function getDTO(): GameDTO
    {
        return new GameDTO(
            $this->str("name"),
            $this->str("description"),
            $this->has("game_visible"),
            $this->file('game_image'),
            $this->file('design')
        );
    }
}
