<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account']) // Ini akan selalu meminta user memilih akun
            ->redirect();
    }

    // public function redirectToProvider($provider)
    // {
    //     if (!in_array($provider, ['facebook', 'google', 'twitter'])) {
    //         return redirect()->route('auth.login')->with('error', 'Social login provider not supported.');
    //     }

    //     return Socialite::driver($provider)->with(['prompt' => 'select_account'])->redirect();
    // }

    public function handleGoogleCallback()
    {
        try {
            // if (!in_array($provider, ['facebook', 'google', 'twitter'])) {
            //     return redirect()->route('auth.login')->with('error', 'Social login provider not supported.');
            // }
            
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            $user = User::updateOrCreate(
                ['provider_id' => $googleUser->id],
                [
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    // 'provider' => $provider,
                    'provider_id' => $googleUser->id,
                    'provider_token' => $googleUser->token,
                    'password' => Hash::make(Str::random(40)),
                ]
            );

            Auth::login($user);
            
            if ($user->role === 'admin') {
                return redirect()->route('dashboard.home');
            } else {
                return redirect()->route('public.home');
            }

        } catch (Exception $e) {
            // Log error jika diperlukan
            \Log::error('Google Login Error: ' . $e->getMessage());
            
            return redirect()->route('auth.login')
                ->with('error', 'Gagal login menggunakan Google. Silakan coba lagi.');
        }
    }
}
