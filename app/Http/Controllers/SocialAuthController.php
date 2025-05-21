<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class SocialAuthController extends Controller
{
    protected $allowedProviders = ['google', 'facebook', 'twitter'];

    public function redirectToProvider($provider)
    {
        if (!in_array($provider, $this->allowedProviders)) {
            return redirect()->route('auth.login')->with('error', 'Social login provider not supported.');
        }

        return Socialite::driver($provider)
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();

            $user = User::updateOrCreate(
                ['provider_id' => $socialUser->id],
                [
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'provider_id' => $socialUser->id,
                    'provider_token' => $socialUser->token,
                    'password' => Hash::make(Str::random(40)),
                ]
            );

            Auth::login($user);

            return response()->view('auth.social-success', [
                'redirectTo' => $user->role === 'admin' ? route('dashboard.home') : route('tenant.home')
            ]);
        } catch (\Exception $e) {
            \Log::error("{$provider} login error: " . $e->getMessage());

            return redirect()->route('auth.login')->with('error', "Gagal login menggunakan {$provider}. Silakan coba lagi.");
        }
    }
}
