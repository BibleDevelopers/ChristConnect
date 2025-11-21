<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
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
        try {
            if (Schema::hasTable('users')) {
                $admin = User::firstOrCreate(
                    ['email' => 'admin@christ.connect'],
                    [
                        'name' => 'admin',
                        'password' => Hash::make('Chr1stConn3ct'),
                        'role' => 'admin',
                        'email_verified_at' => now(), // Already verified
                    ]
                );

                // Ensure admin email is verified (for existing admin accounts)
                if (!$admin->hasVerifiedEmail()) {
                    $admin->email_verified_at = now();
                    $admin->save();
                }

                // Ensure admin has a wallet
                if (!$admin->wallet()->exists()) {
                    $admin->wallet()->create(['balance' => 0]);
                }
            }
        } catch (\Exception $e) {
            // If the database is not available during boot, skip DB-dependent bootstrapping.
            // This prevents artisan/console commands from failing when the DB is down.
            return;
        }

        // Force-register middleware alias
        $router = $this->app['router'];
        $router->aliasMiddleware('admin', \App\Http\Middleware\EnsureUserIsAdmin::class);
    }
}
