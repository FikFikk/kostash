<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function login_process(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|min:6',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            return $user->role === 'admin'
                ? redirect()->intended(route('dashboard.home'))->with('success', 'Berhasil masuk sebagai admin.')
                : redirect()->intended(route('tenant.home'))->with('success', 'Login berhasil. Selamat datang kembali!');
        }

        return back()->withInput()->with('error', 'Email atau kata sandi salah.');
    }

    public function register_process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6', // |confirmed if using password confirmation
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        Auth::login($user);

        return redirect()
            ->route('tenant.home')
            ->with('success', 'Selamat datang! Akun Anda berhasil dibuat dan Anda telah masuk secara otomatis.');
    }

    public function logout_view()
    {
        return view('');
    }

    public function logout_process(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('auth.logout.page'));
    }
}
