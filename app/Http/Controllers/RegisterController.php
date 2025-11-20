<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Events\Registered;
use App\Models\Wallet;
use App\Models\Transaction;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $initialBalance = 50000; // Tentukan saldo awal

        // 1. Buatkan dia Wallet
        $user->wallet()->create([
            'balance' => $initialBalance
        ]);

        // 2. Catat di Transaction
        $user->transactions()->create([
            'user_id' => $user->id, // Pastikan user_id ada di model Transaction
            'type' => 'initial_balance',
            'amount' => $initialBalance, // Positif karena uang masuk
            'description' => 'Saldo awal pendaftaran'
        ]);

        event(new Registered($user));

        Auth::login($user);
        return redirect()->route('login.attempt');
        // return redirect()->route('verification.notice');
    }
}