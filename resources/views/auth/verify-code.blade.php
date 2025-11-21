<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - ChristConnect</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body style="background-image:url('{{ Vite::asset('resources/images/background.jpg') }}');background-size:cover;background-position:center;">
    <div class="auth-container">
        <div class="auth-card">
            <h2>Email Verification</h2>
            
            @if(session('success'))
                <div style="background:#e6ffed;padding:1rem;border-radius:8px;margin-bottom:1rem;border-left:4px solid #10b981;color:#1e4620;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background:#fff4f4;padding:1rem;border-radius:8px;margin-bottom:1rem;border-left:4px solid #ef4444;color:#5a2121;">
                    <ul style="margin:0;padding-left:1.2rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('verification.code.verify') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required readonly style="background:#f5f5f5;">
                </div>

                <div class="form-group">
                    <label for="code">Verification Code (6 digits)</label>
                    <input type="text" id="code" name="code" maxlength="6" pattern="[0-9]{6}" required 
                           placeholder="Enter 6-digit code" style="text-align:center;font-size:1.5rem;letter-spacing:0.5rem;">
                </div>

                <button type="submit" class="btn-submit">Confirm</button>
            </form>

            <div style="margin-top:1rem;text-align:center;">
                <form method="POST" action="{{ route('verification.code.resend') }}" style="display:inline;">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                    <button type="submit" style="background:none;border:none;color:#0b61a4;text-decoration:underline;cursor:pointer;">
                        Resend Code
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
