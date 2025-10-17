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
<body class="dashboard-background">
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
            @auth
                <a href="#">Logout</a>
            @endauth
        </div>
    </header>

    <main>
        <div class="dashboard-container">
            <!-- <h1>Welcome, {{ Auth::user()->name }}!</h1> -->

            <div class="dashboard-card">
                <h2>Personal Information</h2>
                <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            </div>

            <div class="dashboard-card">
                <h2>Keamanan</h2>
                
                <h3>Ganti Password</h3>
                <form action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="current_password">Password Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Password Baru</label>
                        <input type="password" name="new_password" id="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ganti Password</button>
                </form>

                <!-- <hr style="margin: 2rem 0;">

                <h3>Aktifkan Two-Factor Authentication (2FA)</h3>
                <p>Amankan akun anda dengan menggunakan aplikasi 2FA.</p>
                <button class="btn btn-success">Aktifkan 2FA</button> -->
            </div>
        </div>
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>