<?php

namespace App\Http\Requests\Shop;

use App\Http\Requests\BaseRequest;
use App\DataTransfer\Shop\ShopDTO;
use App\DataTransfer\Shop\ShopContactDTO;
use App\DataTransfer\Shop\ShopLocationDTO;
use Illuminate\Contracts\Validation\ValidationRule;

final class SaveUserShopRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "shop_name"                  => "required|string|min:1",
            "shop_name_furigana"         => "required|string|min:1",
            "shop_pr"                    => "sometimes|required|nullable|string",
            "shop_logo"                  => "sometimes|required|nullable|string",
            "shop_location"              => "required|array",
            "shop_location.postal_code"  => "required|string",
            "shop_location.prefecture"   => "required|string",
            "shop_location.address"      => "required|string",
            "shop_location.building"     => "sometimes|required|nullable|string",
            "shop_contact"               => "required|array",
            "shop_contact.name"          => "required|string",
            "shop_contact.name_furigana" => "required|string",
            "shop_contact.phone_number"  => "sometimes|required|nullable|string",
            "shop_contact.url"           => "sometimes|required|nullable|string",
        ];
    }

    public function getDTO(): ShopDTO
    {
        $contactDTO = new ShopContactDTO(
            $this->str("shop_contact.name"),
            $this->str("shop_contact.name_furigana"),
            $this->input("shop_contact.phone_number"),
            $this->input("shop_contact.url"),
        );

        $locationDTO = new ShopLocationDTO(
            $this->str("shop_location.postal_code"),
            $this->str("shop_location.prefecture"),
            $this->str("shop_location.address"),
            $this->input("shop_location.building"),
        );

        return new ShopDTO(
            $this->str("shop_name"),
            $this->str("shop_name_furigana"),
            $contactDTO,
            $locationDTO,
            $this->input("shop_pr"),
            $this->input("shop_logo"),
        );
    }
}
