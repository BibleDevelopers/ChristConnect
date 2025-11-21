<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $observers = [
        // Pastikan tidak ada baris seperti ini:
        // \App\Models\Wallet::class => [\App\Observers\WalletObserver::class],
    ];
    
    // ...existing code...
}