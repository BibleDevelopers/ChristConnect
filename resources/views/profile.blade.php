<x-app class="dashboard-background">
    <div class="dashboard-container">
        <div class="dashboard-card" style="padding:1rem 1rem 0 1rem; margin-bottom:1rem;">
            <div class="profile-header" style="display:flex;align-items:center;gap:1rem;">
                <div class="avatar" style="width:84px;height:84px;border-radius:50%;background:#f3f4f6;display:flex;align-items:center;justify-content:center;font-weight:700;color:#555;font-size:1.25rem;">
                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                </div>
                <div>
                    <h1 style="margin:0;font-size:1.5rem;">{{ Auth::user()->name }}</h1>
                    <p style="margin:.25rem 0 0 0;color:#666;">{{ Auth::user()->email }}</p>
                </div>
                <div style="margin-left:auto;display:flex;gap:.5rem;align-items:center;">
                    <a href="#" class="btn btn-primary" style="padding:.4rem .8rem;">Edit Profile</a>
                </div>
            </div>
        </div>

        {{-- Flash messages / validation errors --}}
        @if(session('status'))
            <div class="dashboard-card" role="status" style="background:#e6ffed;border-left:4px solid #5cb85c;color:#1e4620;">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="dashboard-card" style="background:#fff4f4;border-left:4px solid #ff6b6b;color:#5a2121;">
                <ul style="margin:0;padding-left:1.2rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="profile-grid" style="display:grid;grid-template-columns:1fr 380px;gap:20px;">
            <div class="dashboard-card">
                <h2>Personal Information</h2>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" value="{{ Auth::user()->name }}" disabled>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" value="{{ Auth::user()->email }}" disabled>
                </div>
                {{-- Add any other personal fields below as needed --}}
            </div>

            <div class="dashboard-card">
                <h2>Security</h2>

                <h3 style="margin-top:0.5rem;margin-bottom:.75rem;font-size:1rem;">Change Password</h3>
                <form action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" name="current_password" id="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" name="new_password" id="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required>
                    </div>
                        <div style="display:flex;gap:.5rem;justify-content:flex-end;margin-top:.5rem;">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                        <a href="#" class="btn btn-success" style="background:#6c757d;">Cancel</a>
                    </div>
                </form>

                <hr style="margin:1rem 0;">
                <h3 style="margin-bottom:.5rem;font-size:1rem;">Two-Factor Authentication</h3>
                <p style="color:#666;margin-bottom:.75rem;">Enable 2FA to add an extra layer of security to your account.</p>
                <div style="display:flex;gap:.5rem;">
                    <button class="btn btn-success">Enable 2FA</button>
                </div>
            </div>
        </div>
    </div>
</x-app>