<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('dashboard.tenants.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.tenants.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        logger()->info('Masuk ke fungsi update', $request->all());
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => [
                'nullable',
                'string',
                Rule::unique('users')->ignore($user->id),
            ],
            'nik' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nik' => $request->nik,
            'address' => $request->address,
        ];

        logger()->info('Validasi berhasil');

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists('uploads/profile/' . $user->photo)) {
                Storage::disk('public')->delete('uploads/profile/' . $user->photo);
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/profile', $filename, 'public');

            $data['photo'] = $filename;
        }

        $user->update($data);

        return redirect()->route('tenant.profile.index')->with('success', 'Profil berhasil diperbarui');
    }

    public function changePasswordForm()
    {
        return view('dashboard.tenants.profile.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak benar']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('tenant.profile.index')->with('success', 'Password berhasil diubah');
    }
}
