<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Mail\EmailVerificationCode;

class LoginController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $email = (string) $request->input('email');
        $key = 'login|' . Str::lower($email) . '|' . $request->ip();
        $maxAttempts = 5;
        $decaySeconds = 300; // lockout window (5 minutes)

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            Log::warning("Login lockout for {$email} from {$request->ip()}", ['email' => $email, 'ip' => $request->ip()]);
            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login. Coba lagi setelah $seconds detik."
            ]);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            // clear attempts on success
            RateLimiter::clear($key);

            $request->session()->regenerate();

            $user = Auth::user();

            // Check if email is not verified
            if (!$user->hasVerifiedEmail()) {
                // If a still-valid verification code exists, don't resend
                $expiresAt = $user->email_verification_expires_at;
                $shouldSend = true;
                if ($expiresAt) {
                    try {
                        if (method_exists($expiresAt, 'isFuture') && $expiresAt->isFuture()) {
                            $shouldSend = false;
                        } elseif (strtotime((string)$expiresAt) > time()) {
                            $shouldSend = false;
                        }
                    } catch (\Throwable $e) {
                        // fallback: will resend
                        $shouldSend = true;
                    }
                }

                if ($shouldSend) {
                    // Generate new verification code and store
                    $code = (string) random_int(100000, 999999);
                    $user->email_verification_code = $code;
                    $user->email_verification_expires_at = now()->addMinutes(15);
                    $user->save();

                    try {
                        Mail::to($user->email)->send(new EmailVerificationCode($code, $user->name));
                    } catch (\Throwable $e) {
                        Log::error('Verification email send failed on login', ['user_id' => $user->id, 'error' => $e->getMessage()]);
                    }
                }

                // Redirect to verification page (do not redirect to dashboard)
                return redirect()->route('verification.code.show', ['email' => $user->email])
                    ->with('status', 'verification-code-sent');
            }

            // Log successful login (IP & user-agent)
            Log::info('User logged in', ['user_id' => $user->id ?? null, 'email' => $user->email ?? null, 'ip' => $request->ip(), 'ua' => $request->userAgent()]);

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang, ' . ($user->name ?? ''));
        }

        // increment attempts and give generic error
        RateLimiter::hit($key, $decaySeconds);

        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }
}