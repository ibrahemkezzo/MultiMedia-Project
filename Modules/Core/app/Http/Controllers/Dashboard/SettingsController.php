<?php

namespace Modules\Core\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Core\Http\Requests\UpdateWebsiteSettingsRequest;
use Modules\Core\Services\WebsiteSettingsService;

class SettingsController extends Controller
{

    private WebsiteSettingsService $service;

    public function __construct(WebsiteSettingsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $settings = $this->service->all();
        return view('core::dashboard.settings.index', compact('settings'));
    }

    public function update(UpdateWebsiteSettingsRequest $request)
    {
        $this->service->updateFromArray($request->validated());
        return redirect()->route('dashboard.settings.index')
            ->with('message', [
            'type'    => 'success',
            'content' => __('Settings Website updated successfully.'),
        ]);;
    }
}
