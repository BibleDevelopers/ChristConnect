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
            // Do not auto-create privileged accounts at application boot. Creating
            // administrator credentials automatically can leak predictable or
            // development credentials into production environments and is a
            // security risk. Use an explicit CLI command or a secure seeder that
            // reads credentials from protected environment variables to create
            // administrators when needed.
            if (Schema::hasTable('users')) {
                // No automated admin creation here.
            }
        } catch (\Exception $e) {
            // If the database is not available during boot, skip DB-dependent bootstrapping.
            return;
        }

        // Force-register middleware alias
        $router = $this->app['router'];
        $router->aliasMiddleware('admin', \App\Http\Middleware\EnsureUserIsAdmin::class);
    }
}
