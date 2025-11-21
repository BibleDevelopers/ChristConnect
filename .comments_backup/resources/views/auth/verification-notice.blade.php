<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Required - ChristConnect</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body style="background-image:url('{{ Vite::asset('resources/images/background.jpg') }}');background-size:cover;background-position:center;">
    <script>
        // Auto-redirect to verification code page
        window.location.href = "{{ route('verification.code.show', ['email' => auth()->user()->email]) }}";
    </script>
</body>
</html>
