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
        $admin = User::firstOrCreate(
            ['email' => 'admin@christ.connect'],
            [
                'name' => 'admin',
                'password' => Hash::make('Chr1stConn3ct'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Pastikan admin punya wallet
        if (!$admin->wallet()->exists()) {
            $admin->wallet()->create(['balance' => 50000]);
        }

        // Force-register middleware alias
        $router = $this->app['router'];
        $router->aliasMiddleware('admin', \App\Http\Middleware\EnsureUserIsAdmin::class);
    }
}
