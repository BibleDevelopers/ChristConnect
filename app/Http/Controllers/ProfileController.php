<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function updateName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // sanitize input to prevent HTML in name
        $clean = trim(strip_tags($request->name));
        if ($clean === '') {
            return back()->withErrors(['name' => 'Nama harus berisi teks yang valid.'])->withInput();
        }

        $user = Auth::user();
        $user->name = $clean;
        $user->save();

        return redirect()->route('profile')->with('status', 'Nama berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers(),
            ],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
            'new_password.min' => 'Password minimal 8 karakter.',
            'new_password.letters' => 'Password harus mengandung huruf.',
            'new_password.mixed_case' => 'Password harus mengandung huruf besar dan kecil.',
            'new_password.numbers' => 'Password harus mengandung angka.',
        ]);

        $user = Auth::user();

        // Rate limiter key per-user+ip for change-password attempts
        $key = 'change-password|' . ($user->id ?? 'guest') . '|' . $request->ip();
        $maxAttempts = 5;
        $decaySeconds = 300; // 5 minutes

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            // log and send lightweight admin alert (no sensitive data)
            Log::warning('Password change rate limit exceeded', [
                'user_id' => $user->id ?? null,
                'email' => $user->email ?? null,
                'ip' => $request->ip(),
                'available_in' => $seconds,
            ]);

            $adminEmail = env('ADMIN_EMAIL');
            if ($adminEmail) {
                try {
                    Mail::raw("Rate limit exceeded for password-change attempts.\nUser: " . ($user->email ?? 'unknown') . "\nIP: " . $request->ip() . "\nWait: {$seconds}s", function ($m) use ($adminEmail) {
                        $m->to($adminEmail)->subject('Security alert: repeated password-change attempts');
                    });
                } catch (\Throwable $e) {
                    Log::error('Failed to send admin alert for password-change rate limit', ['error' => $e->getMessage()]);
                }
            }

            return back()->withErrors(['current_password' => "Terlalu banyak percobaan. Coba lagi setelah $seconds detik."]);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            // record failed attempt
            RateLimiter::hit($key, $decaySeconds);

            // optional lightweight logging for each failed try (avoid logging raw passwords)
            Log::notice('Failed password change attempt', [
                'user_id' => $user->id ?? null,
                'email' => $user->email ?? null,
                'ip' => $request->ip(),
            ]);

            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        // success -> clear attempts and perform password change
        RateLimiter::clear($key);

        $user->password = Hash::make($request->new_password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        // regenerate session to mitigate session fixation
        $request->session()->regenerate();

        Log::info('User changed password', ['user_id' => $user->id ?? null, 'ip' => $request->ip()]);

        return redirect()->route('profile')->with('status', 'Password berhasil diubah.');
    }
}