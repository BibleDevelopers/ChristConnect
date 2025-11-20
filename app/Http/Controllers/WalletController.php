<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('wallet', 'transactions');
        
        // Auto-create wallet if missing
        if (!$user->wallet) {
            $user->wallet()->create(['balance' => 50000]);
            $user->load('wallet');
        }
        
        $transactions = $user->transactions()->latest()->paginate(10);
        
        return view('wallet.index', compact('user', 'transactions'));
    }

    public function topup(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:10000|max:10000000',
        ]);

        $user = Auth::user();
        $amount = (int) $request->input('amount');

        DB::transaction(function () use ($user, $amount) {
            $wallet = $user->wallet()->lockForUpdate()->first();
            
            if (!$wallet) {
                $wallet = $user->wallet()->create(['balance' => 0]);
            }
            
            $wallet->increment('balance', $amount);
            
            $user->transactions()->create([
                'type' => 'topup',
                'amount' => $amount,
                'description' => 'Top-up saldo wallet',
            ]);
        });

        return redirect()->route('wallet.index')->with('success', 'Top-up berhasil! Saldo Anda bertambah Rp' . number_format($amount, 0, ',', '.'));
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:10000',
        ]);

        $user = Auth::user();
        $amount = (int) $request->input('amount');

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
        } catch (\Exception $e) {
            return redirect()->route('wallet.index')->with('error', $e->getMessage());
        }

        return redirect()->route('wallet.index')->with('success', 'Penarikan berhasil! Saldo Anda berkurang Rp' . number_format($amount, 0, ',', '.'));
    }
}
