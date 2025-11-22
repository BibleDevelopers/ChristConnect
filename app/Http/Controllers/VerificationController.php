<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerificationCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class VerificationController extends Controller
{
    public function show(Request $request)
    {
        // allow pre-filling email via query param (from registration)
        $email = $request->query('email', '');
        return view('auth.verify_code', compact('email'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        if ($user->email_verification_code !== $request->code) {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }

        // defensive: handle null/empty expires_at
        if (empty($user->email_verification_expires_at) || Carbon::parse($user->email_verification_expires_at)->isPast()) {
            return back()->withErrors(['code' => 'Verification code has expired.']);
        }

        $user->email_verified_at = now();
        $user->email_verification_code = null;
        $user->email_verification_expires_at = null;
        $user->save();

        // Login user if not already logged in
        if (!Auth::check()) {
            Auth::login($user);
        }

        return redirect()->route('dashboard')->with('success', 'Email verified successfully!');
    }

    public function resend(Request $request)
    {
        $request->validate([ 'email' => ['required','email'] ]);

        $email = (string)$request->input('email');
        $key = 'verify-resend|' . strtolower($email) . '|' . $request->ip();
        $maxAttempts = 3;
        $decaySeconds = 600; // 10 minutes

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            Log::warning("Verification resend rate limit reached for {$email}", ['email' => $email, 'ip' => $request->ip()]);
            throw ValidationException::withMessages(['email' => "Terlalu sering meminta kode. Coba lagi setelah $seconds detik."]);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            RateLimiter::hit($key, $decaySeconds);
            return back()->withErrors(['email' => 'Alamat email tidak ditemukan.']);
        }

        $code = (string) random_int(100000, 999999);
        $user->email_verification_code = $code;
        $user->email_verification_expires_at = Carbon::now()->addMinutes(15);
        $user->save();

        // send email synchronously for reliable delivery (fallback to logs on failure)
        try {
            Mail::to($user->email)->send(new EmailVerificationCode($code, $user->name));
        } catch (\Throwable $e) {
            Log::error('Verification resend email send failed', ['email' => $user->email, 'error' => $e->getMessage()]);
        }

        RateLimiter::hit($key, $decaySeconds);

        return back()->with('status', 'verification-code-resent');
    }
}
