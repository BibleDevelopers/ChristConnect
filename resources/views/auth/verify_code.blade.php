@extends('layouts.app')

@section('content')
<div style="max-width:640px;margin:2rem auto;">
    <div class="dashboard-card">
    <h2 style="text-align:center">Email Verification</h2>

        @if(session('status') === 'verification-code-resent')
            <div style="background:#e6f7ff;border-left:4px solid #2b9ed9;padding:0.75rem;margin-bottom:0.75rem;">Verification code has been resent.</div>
        @endif

        @if(session('status') === 'email-verified')
            <div style="background:#e6ffed;border-left:4px solid #5cb85c;padding:0.75rem;margin-bottom:0.75rem;">Email verified successfully. Please login.</div>
        @endif

        @if($errors->any())
            <div style="background:#fff4f4;border-left:4px solid #ff6b6b;padding:0.75rem;margin-bottom:0.75rem;">
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
                
                <input type="hidden" name="email" value="{{ old('email', $email) }}">
                <input id="email_display" type="text" value="{{ old('email', $email) }}" disabled style="width:100%;background:#f5f5f5;">
            </div>

            <div class="form-group">
                <label for="code">Verification Code (6 digits)</label>
                <input id="code" name="code" type="text" inputmode="numeric" pattern="\d{6}" maxlength="6" required style="width:100%;letter-spacing:4px;font-size:1.25rem;text-align:center;">
            </div>

            <div style="display:flex;gap:.5rem;justify-content:space-between;align-items:center;margin-top:.75rem;">
                <div>
                    
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
                <div>
                    
                    <form method="POST" action="{{ route('verification.code.resend') }}" style="display:inline;">
                        @csrf
                        <input type="hidden" name="email" value="{{ old('email', $email) }}">
                        <button type="submit" class="btn">Send</button>
                    </form>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
