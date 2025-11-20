<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode Verifikasi</title>
</head>
<body>
    <p>Halo {{ $name ?? 'Pengguna' }},</p>
    <p>Terima kasih telah mendaftar. Gunakan kode verifikasi berikut untuk mengonfirmasi alamat email Anda:</p>
    <h2 style="letter-spacing:4px">{{ $code }}</h2>
    <p>Kode ini berlaku selama 15 menit. Jika Anda tidak meminta kode ini, abaikan email ini.</p>
    <p>Salam,<br>Tim ChristConnect</p>
</body>
</html>
