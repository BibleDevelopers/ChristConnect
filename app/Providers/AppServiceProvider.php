<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        
    }

    
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
                        'email_verified_at' => now(), 
                    ]
                );

                
                if (!$admin->hasVerifiedEmail()) {
                    $admin->email_verified_at = now();
                    $admin->save();
                }

                
                if (!$admin->wallet()->exists()) {
                    $admin->wallet()->create(['balance' => 0]);
                }
            }
        } catch (\Exception $e) {
            
            
            return;
        }

        
        $router = $this->app['router'];
        $router->aliasMiddleware('admin', \App\Http\Middleware\EnsureUserIsAdmin::class);
    }
}
