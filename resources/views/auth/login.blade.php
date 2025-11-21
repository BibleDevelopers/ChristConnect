<x-loginregister 
    title="Login"
    action="{{ route('login.attempt') }}"
    buttonText="Login"
    switchText="Don't have an account?"
    switchLink="{{ route('register') }}"
    switchLinkText="Register here"
>
    
    <div class="form-group">
        <label for="email">Email Address</label>
        <input id="email" type="email" name="email" required autofocus>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background:#e6ffed;padding:1rem;border-radius:8px;margin-bottom:1rem;border-left:4px solid #10b981;color:#1e4620;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="background:#fff4f4;padding:1rem;border-radius:8px;margin-bottom:1rem;border-left:4px solid #ef4444;color:#5a2121;">
            {{ session('error') }}
        </div>
    @endif

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