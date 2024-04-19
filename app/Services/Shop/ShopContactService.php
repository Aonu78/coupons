<?php

namespace App\Services\Shop;

use App\Models\Shop;
use App\Models\ShopContact;
use Illuminate\Support\Str;
use App\DataTransfer\Shop\ShopContactDTO;

final class ShopContactService
{
    public function __construct(
        private readonly ShopContact $shopContactModel
    ) {}

    public function create(Shop $shop, ShopContactDTO $shopContactDTO): ShopContact
    {
        $contact = $this->shopContactModel->newInstance();

        $contact->shop()->associate($shop);

        $contact->contact_uuid = Str::uuid();
        $contact->contact_name = $shopContactDTO->contactName;
        $contact->contact_name_furigana = $shopContactDTO->contactNameFurigana;
        $contact->contact_phone_number = $shopContactDTO->contactPhoneNumber;
        $contact->shop_url = $shopContactDTO->shopUrl;

        $contact->save();

        return $contact;
    }

    public function update(ShopContact $shopContact, ShopContactDTO $shopContactDTO): ShopContact
    {
        $shopContact->contact_name = $shopContactDTO->contactName;
        $shopContact->contact_name_furigana = $shopContactDTO->contactNameFurigana;
        $shopContact->contact_phone_number = $shopContactDTO->contactPhoneNumber;
        $shopContact->shop_url = $shopContactDTO->shopUrl;

        $shopContact->save();

        return $shopContact;
    }
}
