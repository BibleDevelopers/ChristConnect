<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    // require authenticated user
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user()->load('wallet', 'transactions');
        
        // Auto-create wallet if missing
        if (!$user->wallet) {
            $user->wallet()->create(['balance' => 0]);
            $user->load('wallet');
        }
        
        $transactions = $user->transactions()->latest()->paginate(10);
        
        return view('wallet.index', compact('user', 'transactions'));
    }

    public function topup(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Rate limiter: limit topup attempts per-user
        $key = 'wallet-topup|' . $user->id;
        $maxAttempts = 5;
        $decaySeconds = 60; // 1 minute

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Terlalu banyak percobaan. Coba lagi setelah $seconds detik.");
        }

        // validate into named bag 'topup' so view can show specific errors
        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer|min:10000|max:10000000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'topup')->withInput();
        }

        $amount = (int) $request->input('amount');

        // defensive: ensure wallet exists
        if (!$user->wallet) {
            try {
                $user->wallet()->create(['balance' => 0]);
                $user->load('wallet');
            } catch (\Throwable $e) {
                Log::error('Failed to create wallet on topup', ['user_id' => $user->id ?? null, 'error' => $e->getMessage()]);
                return back()->with('error', 'Tidak dapat mengakses dompet Anda saat ini. Silakan coba lagi nanti.');
            }
        }

        // count attempt
        RateLimiter::hit($key, $decaySeconds);

        try {
            DB::transaction(function () use ($user, $amount) {
                $wallet = $user->wallet()->lockForUpdate()->first();
                if (!$wallet) {
                    throw new \Exception('Wallet tidak ditemukan.');
                }

                $wallet->increment('balance', $amount);

                $user->transactions()->create([
                    'type' => 'topup',
                    'amount' => $amount,
                    'description' => 'Top-up saldo wallet',
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('Topup failed', ['user_id' => $user->id ?? null, 'amount' => $amount, 'error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat proses top-up. Silakan coba lagi.');
        }

        // success → clear limiter
        RateLimiter::clear($key);

        return redirect()->route('wallet.index')->with('success', 'Top-up berhasil! Saldo Anda bertambah Rp' . number_format($amount, 0, ',', '.'));
    }

    public function withdraw(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Rate limiter: limit withdraw attempts per-user
        $key = 'wallet-withdraw|' . $user->id;
        $maxAttempts = 5;
        $decaySeconds = 60; // 1 minute

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Terlalu banyak percobaan. Coba lagi setelah $seconds detik.");
        }

        // validate into named bag 'withdraw'
        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer|min:10000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'withdraw')->withInput();
        }

        $amount = (int) $request->input('amount');

        // count attempt
        RateLimiter::hit($key, $decaySeconds);

        try {
            DB::transaction(function () use ($user, $amount) {
                $wallet = $user->wallet()->lockForUpdate()->first();
                
                if (!$wallet) {
                    throw new \Exception('Wallet tidak ditemukan. Silakan hubungi administrator.');
                }
                
                if ($wallet->balance < $amount) {
                    throw new \Exception('Saldo tidak mencukupi untuk penarikan.');
                }
                
                $wallet->decrement('balance', $amount);
                
                $user->transactions()->create([
                    'type' => 'withdrawal',
                    'amount' => -$amount,
                    'description' => 'Penarikan dana dari wallet',
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('Withdraw failed', ['user_id' => $user->id ?? null, 'amount' => $amount, 'error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat proses penarikan. Silakan coba lagi.');
        }

        // success → clear limiter
        RateLimiter::clear($key);

        return redirect()->route('wallet.index')->with('success', 'Penarikan berhasil! Saldo Anda berkurang Rp' . number_format($amount, 0, ',', '.'));
    }
}
