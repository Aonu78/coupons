<?php

namespace App\Services\Shop;

use App\Models\Shop;
use Illuminate\Support\Str;
use App\Models\ShopLocation;
use App\DataTransfer\Shop\ShopLocationDTO;

final class ShopLocationService
{
    public function __construct(
        private readonly ShopLocation $shopLocationModel
    ) {}

    public function create(Shop $shop, ShopLocationDTO $shopLocationDTO): ShopLocation
    {
        $location = $this->shopLocationModel->newInstance();

        $location->shop()->associate($shop);
        $location->location_uuid = Str::uuid();
        $location->shop_postal_code = $shopLocationDTO->postalCode;
        $location->shop_prefecture = $shopLocationDTO->prefecture;
        $location->shop_address = $shopLocationDTO->address;
        $location->shop_building_number = $shopLocationDTO->buildingNumber;

        $location->save();

        return $location;
    }

    public function update(ShopLocation $shopLocation, ShopLocationDTO $shopLocationDTO): ShopLocation
    {
        $shopLocation->shop_postal_code = $shopLocationDTO->postalCode;
        $shopLocation->shop_prefecture = $shopLocationDTO->prefecture;
        $shopLocation->shop_address = $shopLocationDTO->address;
        $shopLocation->shop_building_number = $shopLocationDTO->buildingNumber;

        $shopLocation->save();

        return $shopLocation;
    }
}
