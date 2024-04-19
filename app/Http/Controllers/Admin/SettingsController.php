<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Settings\SettingService;
use App\Http\Requests\Admin\Settings\SaveRequest;

final class SettingsController extends Controller
{
    public function __construct(
        private readonly SettingService $settingService
    ) {}

    public function index()
    {
        $settings = $this->settingService->all();

        return view('admin.settings.create', compact('settings'));
    }

    public function save(SaveRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->settingService->updateMany($request->getDTO());

        return redirect()->route('admin.settings.index')
            ->with("success", "You have successfully updated system settings");
    }
}
