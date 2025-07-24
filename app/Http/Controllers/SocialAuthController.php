<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Exception;
use Carbon\Carbon;

class SocialAuthController extends Controller
{
    private const ALLOWED_PROVIDERS = ['google', 'facebook', 'twitter'];
    private const ADMIN_ROUTE = 'dashboard.home';
    private const TENANT_ROUTE = 'tenant.home';
    private const LOGIN_ROUTE = 'auth.login';
    private const MAX_SOCIAL_ATTEMPTS = 10;
    private const RATE_LIMIT_DURATION = 3600;
    
    public function redirectToProvider(string $provider): RedirectResponse
    {
        if (!$this->isValidProvider($provider)) {
            Log::warning('Invalid social provider attempted', [
                'provider' => $provider,
                'ip' => request()->ip(),
            ]);

            return redirect()
                ->route(self::LOGIN_ROUTE)
                ->with('error', "Provider {$provider} tidak didukung.");
        }

        $this->checkRateLimit($provider);

        try {
            Log::info('Social auth redirect initiated', [
                'provider' => $provider,
                'ip' => request()->ip(),
            ]);

            return Socialite::driver($provider)
                ->with(['prompt' => 'select_account'])
                ->redirect();

        } catch (Exception $e) {
            Log::error('Social auth redirect failed', [
                'provider' => $provider,
                'error' => $e->getMessage(),
                'ip' => request()->ip(),
            ]);
            
            return redirect()
                ->route(self::LOGIN_ROUTE)
                ->with('error', 'Terjadi kesalahan saat menghubungkan ke provider.');
        }
    }

    public function handleProviderCallback(string $provider): Response|RedirectResponse
    {
        if (!$this->isValidProvider($provider)) {
            Log::warning('Invalid social provider callback', [
                'provider' => $provider,
                'ip' => request()->ip(),
            ]);

            return redirect()
                ->route(self::LOGIN_ROUTE)
                ->with('error', "Provider {$provider} tidak didukung.");
        }

        $this->checkRateLimit($provider . '_callback');

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
            
            if (!$socialUser || !$socialUser->email) {
                Log::warning('Social auth missing email', [
                    'provider' => $provider,
                    'social_id' => $socialUser->id ?? 'unknown',
                    'ip' => request()->ip(),
                ]);

                return redirect()
                    ->route(self::LOGIN_ROUTE)
                    ->with('error', 'Email diperlukan untuk mendaftar. Silakan berikan akses email.');
            }

            if (!filter_var($socialUser->email, FILTER_VALIDATE_EMAIL)) {
                Log::warning('Invalid email from social provider', [
                    'provider' => $provider,
                    'email' => $socialUser->email,
                    'ip' => request()->ip(),
                ]);

                return redirect()
                    ->route(self::LOGIN_ROUTE)
                    ->with('error', 'Email dari provider tidak valid.');
            }

            $user = $this->findOrCreateUser($socialUser, $provider);
            
            Auth::login($user);
            request()->session()->regenerate();

            $this->clearRateLimit($provider . '_callback');

            Log::info('Social auth successful', [
                'provider' => $provider,
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => request()->ip(),
            ]);

            $route = $user->role === 'admin' ? self::ADMIN_ROUTE : self::TENANT_ROUTE;
            $message = "Berhasil masuk menggunakan " . ucfirst($provider) . ".";

            return response()->view('auth.social-success', [
                'redirectTo' => route($route),
                'message' => $message,
            ]);

        } catch (Exception $e) {
            Log::error('Social auth callback failed', [
                'provider' => $provider,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => request()->ip(),
            ]);
            
            return redirect()
                ->route(self::LOGIN_ROUTE)
                ->with('error', 'Terjadi kesalahan saat proses login. Silakan coba lagi.');
        }
    }

    private function findOrCreateUser($socialUser, string $provider): User
    {
        $name = $this->sanitizeName($socialUser->name);
        $email = strtolower(trim($socialUser->email));

        $existingUser = User::where('email', $email)->first();
        
        if ($existingUser) {
            if (!$existingUser->provider_id) {
                $existingUser->update([
                    'provider_id' => $socialUser->id,
                    'provider_token' => $this->hashToken($socialUser->token),
                    'provider' => $provider,
                    'updated_at' => Carbon::now(),
                ]);

                Log::info('Updated existing user with social provider', [
                    'user_id' => $existingUser->id,
                    'provider' => $provider,
                ]);
            }
            return $existingUser;
        }

        $socialAccount = User::where('provider_id', $socialUser->id)
                            ->where('provider', $provider)
                            ->first();

        if ($socialAccount) {
            Log::warning('Social account exists with different email', [
                'existing_email' => $socialAccount->email,
                'new_email' => $email,
                'provider' => $provider,
                'social_id' => $socialUser->id,
            ]);

            if ($socialAccount->email !== $email) {
                $socialAccount->update([
                    'email' => $email,
                    'updated_at' => Carbon::now(),
                ]);
            }

            return $socialAccount;
        }

        $newUser = User::create([
            'name' => $name,
            'email' => $email,
            'provider_id' => $socialUser->id,
            'provider_token' => $this->hashToken($socialUser->token),
            'provider' => $provider,
            'password' => Hash::make(Str::random(64)),
            'role' => 'tenant',
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Log::info('Created new social user', [
            'user_id' => $newUser->id,
            'email' => $email,
            'provider' => $provider,
        ]);

        return $newUser;
    }

    private function isValidProvider(string $provider): bool
    {
        return in_array($provider, self::ALLOWED_PROVIDERS, true);
    }

    private function sanitizeName(?string $name): string
    {
        if (!$name) {
            return 'User';
        }

        $name = preg_replace('/[^\p{L}\p{N}\s\-\'\.]/u', '', $name);
        $name = trim($name);
        
        return substr($name, 0, 255) ?: 'User';
    }

    private function hashToken(?string $token): ?string
    {
        return $token ? hash('sha256', $token) : null;
    }

    private function checkRateLimit(string $action): void
    {
        $key = "social_auth_{$action}|" . request()->ip();
        
        if (RateLimiter::tooManyAttempts($key, self::MAX_SOCIAL_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($key);
            
            Log::warning("Social auth rate limit exceeded", [
                'action' => $action,
                'ip' => request()->ip(),
                'seconds_remaining' => $seconds,
            ]);

            throw ValidationException::withMessages([
                'error' => "Terlalu banyak percobaan. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        RateLimiter::hit($key, self::RATE_LIMIT_DURATION);
    }

    private function clearRateLimit(string $action): void
    {
        $key = "social_auth_{$action}|" . request()->ip();
        RateLimiter::clear($key);
    }
}
