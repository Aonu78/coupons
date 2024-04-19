<?php

namespace App\Http\Controllers\Api\Shop;

use Illuminate\Http\Request;
use App\Support\Http\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Location\LocationService;
use App\Http\Resources\Shop\LocationTransformer;

final class LocationsController extends Controller
{
    public function __construct(
        private readonly LocationService $locationService
    ) {}

    public function find(Request $request, ApiResponse $response)
    {
        $location = $this->locationService->find($request->str("code"));

        if (is_null($location)) {
            return $response->success(null);
        }

        return $response->success(new LocationTransformer($location));
    }
}
