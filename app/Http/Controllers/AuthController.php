<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    private const ADMIN_ROUTE = 'dashboard.home';
    private const TENANT_ROUTE = 'tenant.home';
    private const LOGIN_ROUTE = 'auth.login';
    private const LOGOUT_ROUTE = 'auth.logout.page';
    private const MAX_LOGIN_ATTEMPTS = 5;
    private const LOCKOUT_DURATION = 900;

    public function login(): View
    {
        return view('auth.login');
    }

    public function register(): View
    {
        return view('auth.register');
    }

    public function loginProcess(Request $request): RedirectResponse
    {
        $this->checkRateLimit($request);

        $credentials = $request->validate([
            'email' => 'required|email|min:6|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            $this->incrementLoginAttempts($request);
            
            Log::warning('Failed login attempt', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            throw ValidationException::withMessages([
                'email' => 'Email atau kata sandi salah.',
            ]);
        }

        $this->clearLoginAttempts($request);
        $request->session()->regenerate();
        
        $user = Auth::user();
        
        // Log successful login
        Log::info('Successful login', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
        ]);

        $route = $user->role === 'admin' ? self::ADMIN_ROUTE : self::TENANT_ROUTE;
        $message = $user->role === 'admin' 
            ? 'Berhasil masuk sebagai admin.' 
            : 'Login berhasil. Selamat datang kembali!';

        return redirect()->intended(route($route))->with('success', $message);
    }

    public function registerProcess(Request $request): RedirectResponse
    {
        $this->checkRateLimit($request, 'register');

        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            'terms' => 'required|accepted',
        ], [
            'password.regex' => 'Password harus mengandung minimal 1 huruf kecil, 1 huruf besar, 1 angka, dan 1 karakter khusus.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'tenant',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            Log::info('New user registered', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
            ]);

            return redirect()
                ->route(self::TENANT_ROUTE)
                ->with('success', 'Selamat datang! Akun Anda berhasil dibuat dan Anda telah masuk secara otomatis.');

        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);

            return back()
                ->withInput($request->except('password'))
                ->with('error', 'Terjadi kesalahan saat membuat akun. Silakan coba lagi.');
        }
    }

    public function lockScreen(): View
    {
        if (!auth()->check()) {
            return redirect()->route(self::LOGIN_ROUTE);
        }

        session([
            'screen_locked' => true, 
            'lock_time' => now(),
            'locked_user_id' => auth()->id()
        ]);

        return view('auth.lock-screen');
    }

    public function unlockProcess(Request $request): RedirectResponse
    {
        if (!auth()->check() || !session('screen_locked')) {
            return redirect()->route(self::LOGIN_ROUTE);
        }

        $this->checkRateLimit($request, 'unlock');

        $request->validate([
            'password' => 'required|string|max:255'
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            Log::warning('Failed screen unlock attempt', [
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
            ]);

            throw ValidationException::withMessages([
                'password' => 'Password salah'
            ]);
        }

        session()->forget(['screen_locked', 'lock_time', 'locked_user_id']);

        Log::info('Screen unlocked', [
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
        ]);

        return redirect()
            ->intended(route(self::ADMIN_ROUTE))
            ->with('success', 'Screen unlocked successfully! Welcome back, ' . auth()->user()->name);
    }

    public function logoutView(): View
    {
        return view('auth.logout');
    }

    public function logoutProcess(Request $request): RedirectResponse
    {
        $userId = auth()->id();
        
        Log::info('User logged out', [
            'user_id' => $userId,
            'ip' => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route(self::LOGOUT_ROUTE)
            ->with('success', 'Anda telah berhasil keluar.');
    }

    private function checkRateLimit(Request $request, string $action = 'login'): void
    {
        $key = $action . '|' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, self::MAX_LOGIN_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($key);
            
            Log::warning("Rate limit exceeded for {$action}", [
                'ip' => $request->ip(),
                'email' => $request->email ?? 'N/A',
                'seconds_remaining' => $seconds,
            ]);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }
    }

    private function incrementLoginAttempts(Request $request): void
    {
        RateLimiter::hit(
            'login|' . $request->ip(),
            self::LOCKOUT_DURATION
        );
    }

    private function clearLoginAttempts(Request $request): void
    {
        RateLimiter::clear('login|' . $request->ip());
    }
}
