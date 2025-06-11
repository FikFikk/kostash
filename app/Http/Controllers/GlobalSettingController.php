<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\NotificationTrait;

class GlobalSettingController extends Controller
{
    use NotificationTrait;

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

        try {
            $this->getSetting()->update($validated);
    
            return $this->redirectToWithSuccess('dashboard.global.index', 'Global settings berhasil diperbarui!');

        } catch (\Exception $e) {

            return $this->redirectWithError('Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
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
