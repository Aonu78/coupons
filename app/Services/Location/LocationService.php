<?php

namespace App\Services\Location;

use App\Models\Location;

final class LocationService
{
    public function __construct(
        private readonly Location $locationModel
    ) {}

    public function find(string $postalCode): ?Location
    {
        $query = $this->locationModel->newQuery();

        return $query->where("location_postal_code", $postalCode)->first();
    }
}
