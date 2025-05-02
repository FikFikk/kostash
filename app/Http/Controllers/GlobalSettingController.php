<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use Illuminate\Http\Request;

class GlobalSettingController extends Controller
{
    public function index()
    {
        $global = GlobalSetting::first();
        return view('admin.dashboard.global.index', compact('global'));
    }

    public function edit($id)
    {
        $global = GlobalSetting::findOrFail($id);
        return view('admin.dashboard.global.edit', compact('global'));
    }

    public function update(Request $request, $id)
    {
        $global = GlobalSetting::findOrFail($id);

        $validated = $request->validate([
            'monthly_room_price' => 'required|integer|min:0',
            'water_price' => 'required|integer|min:0',
            'electric_price' => 'required|integer|min:0',
        ]);

        $global->update($validated);

        return redirect()->route('global.index')->with('success', 'Global settings updated successfully.');
    }
}
