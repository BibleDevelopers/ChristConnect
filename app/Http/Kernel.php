<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    
    protected $middleware = [
        \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\EncryptCookies::class,
        \App\Http\Middleware\AddQueuedCookiesToResponse::class,
        \App\Http\Middleware\StartSession::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \App\Http\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\View\Middleware\ShareViewErrors::class,
        \App\Http\Middleware\RedirectIfAuthenticated::class,
    ];

    
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
    ];

    
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\TrustHosts::class,
            \App\Http\Middleware\TrustProxies::class,
            \App\Http\Middleware\HandleCors::class,
            \App\Http\Middleware\EncryptCookies::class,
            \App\Http\Middleware\AddQueuedCookiesToResponse::class,
            \App\Http\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \App\Http\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\View\Middleware\ShareViewErrors::class,
            \App\Http\Middleware\RedirectIfAuthenticated::class,
            \App\Http\Middleware\PreventBackHistory::class,
        ],
    ];
}