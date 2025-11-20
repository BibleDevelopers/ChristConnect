<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerificationCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            'email' => ['required','email'],
            'code' => ['required','digits:6'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Alamat email tidak ditemukan.']);
        }

        if (!$user->email_verification_code || !$user->email_verification_expires_at) {
            return back()->withErrors(['code' => 'Tidak ada kode verifikasi yang aktif. Silakan minta kirim ulang.']);
        }

        if (Carbon::now()->greaterThan(Carbon::parse($user->email_verification_expires_at))) {
            return back()->withErrors(['code' => 'Kode verifikasi sudah kadaluwarsa. Silakan kirim ulang kode.']);
        }

        if (!hash_equals($user->email_verification_code, $request->code)) {
            return back()->withErrors(['code' => 'Kode yang Anda masukkan salah.']);
        }

        // correct — mark email as verified
        $user->email_verified_at = Carbon::now();
        $user->email_verification_code = null;
        $user->email_verification_expires_at = null;
        $user->save();

        return redirect()->route('login')->with('status', 'email-verified');
    }

    public function resend(Request $request)
    {
        $request->validate([ 'email' => ['required','email'] ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Alamat email tidak ditemukan.']);
        }

        $code = (string) random_int(100000, 999999);
        $user->email_verification_code = $code;
        $user->email_verification_expires_at = Carbon::now()->addMinutes(15);
        $user->save();

        // send email
        Mail::to($user->email)->send(new EmailVerificationCode($code, $user->name));

        return back()->with('status', 'verification-code-resent');
    }
}
