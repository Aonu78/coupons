<?php

namespace App\Services\Settings;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use App\DataTransfer\Settings\IndexSettingsDTO;
use App\DataTransfer\Settings\UpdateSettingsDTO;

final class SettingService
{
    public function __construct(
        private readonly Setting $setting
    ) {}

    public function all(): IndexSettingsDTO
    {
        $query = $this->setting->newQuery();
        $settings = $query->get();

        return IndexSettingsDTO::createFromCollection($settings);
    }

    public function find(string $key): mixed
    {
        $query = $this->setting->newQuery();

        return $query->where("setting_key", $key)->first();
    }

    public function updateMany(UpdateSettingsDTO $settings): IndexSettingsDTO
    {
        foreach ($settings->getArray() as $key => $value) {
            $this->update($key, $value);
        }

        return $this->all();
    }

    public function update(string $key, mixed $value): Setting
    {
        $query = $this->setting->newQuery();

        return $query->updateOrCreate(["setting_key" => $key], [
            "setting_value" => $value
        ]);
    }
}
