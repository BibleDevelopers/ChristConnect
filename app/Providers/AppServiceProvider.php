<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@christ.connect'],
            [
                'name' => 'admin',
                'password' => Hash::make('Chr1stConn3ct'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
