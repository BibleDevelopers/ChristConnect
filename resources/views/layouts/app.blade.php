<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ChristConnect')</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Open+Sans&display=swap" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php($isAdmin = auth()->check() && auth()->user()->role === 'admin')

<body class="{{ Route::currentRouteName() }}">
    <header>
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Christ Connect Logo">
            </a>
        </div>

        <nav class="center-links">
            <a href="{{ route('alkitab') }}">Bible</a> |
            <a href="{{ route('renungan') }}">Daily Devotional</a> |
            <a href="{{ route('donations.index') }}">Donations</a>
            @auth
                | <a href="{{ route('wallet.index') }}">Wallet</a>
            @endauth
            @if($isAdmin)
                | <a href="{{ route('admin.users.index') }}">Manage Users</a>
                | <a href="{{ route('admin.transactions.index') }}">Manage Transactions</a>
            @endif
        </nav>

        <div class="auth-links">
            @guest 
                <a href="{{ route('login') }}">Login</a> |
                <a href="{{ route('register') }}">Register</a>
            @endguest

            @auth
                <a href="{{ route('profile') }}">Profile</a> |
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                    </a>
                </form>
            @endauth
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
