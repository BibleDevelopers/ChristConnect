<x-loginregister
    title="Register"
    action="{{ route('register.attempt') }}"
    buttonText="Register"
    switchText="Already have an account?"
    switchLink="{{ route('login') }}"
    switchLinkText="Login here"
>
    {{-- Slot for form fields --}}
    <div class="form-group">
        <label for="name">Full Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    </div>

    <div class="form-group">
        <label for="email">Email Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    <small style="color:#666;font-size:0.875rem;">Example: name@domain.com</small>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
        <small style="color:#666;font-size:0.875rem;">Min 8 karakter, huruf besar & kecil, angka</small>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="background:#fff4f4;padding:1rem;border-radius:8px;margin-bottom:1rem;border-left:4px solid #ef4444;color:#5a2121;">
            <ul style="margin:0;padding-left:1.2rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</x-loginregister>