<x-loginregister 
    title="Login"
    action="{{ route('login.attempt') }}"
    buttonText="Login"
    switchText="Don't have an account?"
    switchLink="{{ route('register') }}"
    switchLinkText="Register here"
>
    {{-- Slot for form fields --}}
    <div class="form-group">
        <label for="email">Email Address</label>
        <input id="email" type="email" name="email" required autofocus>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
    </div>
</x-loginregister>