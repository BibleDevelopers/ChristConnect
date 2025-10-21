<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChristConnect</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Open+Sans&display=swap" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@props(['page' => ''])
<body {{ $attributes->merge(['class' => '']) }}>
    <header>
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Christ Connect Logo">
            </a>
        </div>

        <nav class="center-links">
            <a href="alkitab">Alkitab</a> |
            <a href="#">Renungan Harian</a> |
            <a href="#">Donasi</a>
        </nav>

        <div class="auth-links">
            @guest 
                <a href="{{ route('login') }}">Login</a> |
                <a href="{{ route('register') }}">Register</a>
            @endguest

            @auth
                @if($page !== 'profile')
                    <a href="profile">Profile</a> |
                @endif
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
        {{ $slot }}
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>