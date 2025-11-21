<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verification Code</title>
</head>
<body>
    <p>Hello {{ $name ?? 'User' }},</p>
    <p>Thanks for signing up. Use the verification code below to confirm your email address:</p>
    <h2 style="letter-spacing:4px">{{ $code }}</h2>
    <p>This code is valid for 15 minutes. If you did not request this code, please ignore this email.</p>
    <p>Regards,<br>The ChristConnect Team</p>
</body>
</html>
