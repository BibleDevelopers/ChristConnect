<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

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

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Check if email is not verified
            if (!$user->hasVerifiedEmail()) {
                // Generate new verification code
                $code = (string) random_int(100000, 999999);
                $user->email_verification_code = $code;
                $user->email_verification_expires_at = now()->addMinutes(15);
                $user->save();
                
                // Send verification code
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\EmailVerificationCode($code, $user->name));
                
                // Redirect to verification page
                return redirect()->route('verification.code.show', ['email' => $user->email])
                    ->with('status', 'verification-code-sent');
            }
            
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        // Login gagal - kredensial salah
        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }
}
