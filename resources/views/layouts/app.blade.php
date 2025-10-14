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

<body class="@yield('body-class')">
    <header>
        <div class="logo">
            <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Christ Connect Logo">
        </div>

        <nav class="center-links">
            <a href="#">Alkitab</a> |
            <a href="#">Renungan Harian</a> |
            <a href="#">Donasi</a>
        </nav>

        <div class="auth-links">
            <a href="#">Login</a> |
            <a href="#">Register</a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>