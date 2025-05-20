<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use Illuminate\Http\Request;

class GlobalSettingController extends Controller
{
    public function index()
    {
        $global = $this->getSetting();
        return view('dashboard.admin.global.index', compact('global'));
    }

    public function edit()
    {
        $global = $this->getSetting();
        return view('dashboard.admin.global.edit', compact('global'));
    }

    public function update(Request $request)
    {
        $validated = $this->validateSettings($request);

        $this->getSetting()->update($validated);

        return redirect()
            ->route('dashboard.global.index')
            ->with('success', 'Global settings updated successfully.');
    }

    // DRY Helper Methods
    protected function getSetting()
    {
        return GlobalSetting::firstOrFail(); // fallback jika tidak ada
    }

    protected function validateSettings(Request $request)
    {
        return $request->validate([
            'monthly_room_price' => 'required|integer|min:0',
            'water_price' => 'required|integer|min:0',
            'electric_price' => 'required|integer|min:0',
        ]);
    }
}
