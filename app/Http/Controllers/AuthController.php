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
        $credentials = $request->only('email', 'password');

        $request->validate([
            'email' => 'required|email|min:6',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
        
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                return redirect()->intended(route('dashboard.home'));
            } else {
                return redirect()->intended(route('tenant.home'));
            }
        }

        return redirect(route('auth.login'))->withInput()->with('error', 'Email atau password salah!');
    }

    public function register_process(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6', // |confirmed Pastikan ada kolom password_confirmation di form jika menggunakan 'confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('auth.login')->with('success', 'Registration successful! You can now log in.');
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
