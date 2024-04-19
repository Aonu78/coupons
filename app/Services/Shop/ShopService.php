<?php

namespace App\Services\Shop;

use App\Models\User;
use App\Models\Shop;
use Illuminate\Support\Str;
use App\Constants\ShopFiles;
use App\DataTransfer\Shop\ShopDTO;
use Illuminate\Support\Facades\DB;
use App\Services\Filesystem\FilesystemService;

final class ShopService
{
    public function __construct(
        private readonly ShopLocationService $shopLocationService,
        private readonly ShopContactService $shopContactService,
        private readonly FilesystemService $filesystemService,
        //Model
        private readonly Shop $shopModel
    ) {}

    public function getUserShop(User $user): ?Shop
    {
        return $user->shop;
    }

    /**
     * @throws \Throwable
     */
    public function create(User $user, ShopDTO $shopDTO): Shop
    {
        return DB::transaction(function () use ($user, $shopDTO) {
            $shop = $this->shopModel->newInstance();

            $shop->user()->associate($user);
            $shop->shop_uuid = Str::uuid();
            $shop->shop_name = $shopDTO->shopName;
            $shop->shop_name_furigana = $shopDTO->shopNameFurigana;
            $shop->shop_pr = $shopDTO->shopPR;

            $shop->save();

            $this->shopLocationService->create($shop, $shopDTO->shopLocation);
            $this->shopContactService->create($shop, $shopDTO->shopContact);

            if ($shopDTO->hasLogo()) {
                $shop = $this->uploadLogo($shop, $shopDTO->convertLogoToFileContent());
            }

            return $shop;
        });
    }

    /**
     * @throws \Throwable
     */
    public function update(Shop $shop, ShopDTO $shopDTO): Shop
    {
        return DB::transaction(function () use ($shop, $shopDTO) {
            $shop->shop_name = $shopDTO->shopName;
            $shop->shop_name_furigana = $shopDTO->shopNameFurigana;
            $shop->shop_pr = $shopDTO->shopPR;

            $shop->save();

            $this->shopLocationService->update($shop->location, $shopDTO->shopLocation);
            $this->shopContactService->update($shop->contact, $shopDTO->shopContact);

            if ($shopDTO->hasLogo()) {
                $shop = $this->uploadLogo($shop, $shopDTO->convertLogoToFileContent());
            }

            return $shop;
        });
    }

    public function uploadLogo(Shop $shop, string $fileContent): Shop
    {
        $logoPath = sprintf(ShopFiles::SHOP_LOGO_PATH, $shop->shop_uuid, time());
        $logoFileName = sprintf(ShopFiles::SHOP_LOGO_FILE, time());

        $fullPath = $logoPath . DIRECTORY_SEPARATOR . $logoFileName;

        $this->filesystemService->save($fullPath, $fileContent);

        $shop->shop_logo = $logoFileName;
        $shop->save();

        return $shop;
    }
}
