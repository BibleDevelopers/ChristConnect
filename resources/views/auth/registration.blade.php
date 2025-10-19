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
        <input id="name" type="text" name="name" required autofocus>
    </div>

    <div class="form-group">
        <label for="email">Email Address</label>
        <input id="email" type="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
        <small style="display: block; margin-top: 5px; color: #6c757d; font-size: 0.8rem;">
            Must be at least 8 characters, with uppercase, lowercase, and numbers.
        </small>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>
    </div>
</x-loginregister>