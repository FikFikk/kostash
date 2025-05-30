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
        return view('dashboard.tenants.profile.index', [
            'user' => Auth::user(),
        ]);
    }

    public function edit()
    {
        return view('dashboard.tenants.profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $this->validatedProfileData($request, $user);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->handlePhotoUpload($request, $user);
        }

        $user->update($data);

        return redirect()
            ->route('tenant.profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }

    public function changePasswordForm()
    {
        return view('dashboard.tenants.profile.change-password');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if (!is_null($user->provider_id)) {
            return back()->withErrors([
                'current_password' => 'Akun Anda terhubung dengan Google, tidak dapat mengubah password.'
            ]);
        }

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini salah.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('tenant.profile.index')
            ->with('success', 'Password berhasil diubah');
    }

    // Private helpers

    private function validatedProfileData(Request $request, $user)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => [
                'nullable', 'string',
                Rule::unique('users')->ignore($user->id),
            ],
            'nik' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }

    private function handlePhotoUpload(Request $request, $user)
    {
        $file = $request->file('photo');

        if (!$file->isValid()) {
            return null;
        }

        if ($user->photo && Storage::disk('public')->exists('uploads/profile/' . $user->photo)) {
            Storage::disk('public')->delete('uploads/profile/' . $user->photo);
        }

        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('uploads/profile', $filename, 'public');

        return $filename;
    }
}
