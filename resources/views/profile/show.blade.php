<x-app class="dashboard-background">
    <div class="dashboard-container">
        <div class="dashboard-card" style="padding:1rem 1rem 0 1rem; margin-bottom:1rem;">
            <div class="profile-header" style="display:flex;align-items:center;gap:1rem;">
                <div class="avatar" style="width:84px;height:84px;border-radius:50%;background:#f3f4f6;display:flex;align-items:center;justify-content:center;font-weight:700;color:#555;font-size:1.25rem;">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
                <div>
                    <h1 style="margin:0;font-size:1.5rem;">{{ $user->name }}</h1>
                    <p style="margin:.25rem 0 0 0;color:#666;">{{ $user->email }}</p>
                </div>
                <div style="margin-left:auto;display:flex;gap:.5rem;align-items:center;">
                    <button id="edit-profile-btn" class="btn" style="padding:.4rem .8rem;background:#6c757d;color:#fff;">Edit Profile</button>
                    <button id="change-password-btn" class="btn btn-primary" style="padding:.4rem .8rem;">Change Password</button>
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

        <div class="profile-grid" style="display:grid;grid-template-columns:1fr;gap:20px;justify-items:center;">
            <div id="info-card" class="dashboard-card" style="width:100%;max-width:720px;">
                <div style="display:flex;flex-direction:column;align-items:center;">
                    <h2 style="width:100%;text-align:center;">Informasi Akun</h2>
                    <div style="width:100%;max-width:560px;">
                        <form id="name-form" action="{{ route('profile.updateName') }}" method="POST" style="margin-bottom:0;">
                            @csrf
                            <div class="form-group">
                                <label>Nama</label>
                                <input id="name-input" name="name" type="text" value="{{ $user->name }}" disabled style="width:100%;">
                            </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" value="{{ $user->email }}" disabled style="width:100%;">
                        </div>
                        <div class="form-group">
                            <label>Email Terverifikasi</label>
                            <input type="text" value="{{ $user->hasVerifiedEmail() ? 'Ya' : 'Belum' }}" disabled style="width:100%;">
                        </div>
                        <div class="form-group">
                                <label>Bergabung Sejak</label>
                                <input type="text" value="{{ $user->created_at->format('d M Y') }}" disabled style="width:100%;">
                        </div>
                            <div id="profile-actions" style="display:none;margin-top:.5rem;display:flex;justify-content:flex-end;gap:.5rem;">
                                <button type="submit" id="save-name-btn" class="btn btn-primary">Simpan</button>
                                <button type="button" id="cancel-edit-btn" class="btn" style="background:#6c757d;color:#fff;">Batal</button>
                            </div>
                        </form>

                        <hr style="margin:1rem 0;">
                        <h3>Wallet Saya</h3>
                        @php($balance = optional($user->wallet)->balance ?? 0)
                        <p><strong>Saldo:</strong> Rp{{ number_format($balance, 0, ',', '.') }}</p>
                        <p><strong>Total Donasi:</strong> Rp{{ number_format($user->total_donated ?? 0, 0, ',', '.') }}</p>

                        <hr style="margin:1rem 0;">
                        <h3>Lencana (Badges)</h3>
                        @if($user->badges->isEmpty())
                            <p>Belum ada badge. Silakan lanjutkan donasi untuk membuka badge.</p>
                        @else
                            <ul style="list-style:none;padding:0;">
                                @foreach($user->badges as $badge)
                                    <li style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.75rem;">
                                        <div>
                                            <strong>{{ $badge->name }}</strong><br>
                                            <small>Minimum donasi: Rp{{ number_format($badge->min_donation, 0, ',', '.') }}</small>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <hr style="margin:1.5rem 0;">
                        <div class="dashboard-card" style="margin-top:1rem;padding:1.5rem 1rem;">
                            <h3 style="margin-bottom:.5rem;font-size:1.1rem;text-align:center;">Two-Factor Authentication (2FA)</h3>
                            <p style="color:#666;margin-bottom:.75rem;text-align:center;">Aktifkan 2FA untuk menambahkan lapisan keamanan pada akun Anda.</p>
                            <div style="display:flex;justify-content:center;gap:.5rem;">
                                <button class="btn btn-success">Aktifkan 2FA</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="security-card" class="dashboard-card" style="display:none;width:100%;max-width:720px;">
                <div style="display:flex;flex-direction:column;align-items:center;">
                    <h2 style="width:100%;text-align:center;">Keamanan</h2>
                    <div style="width:100%;max-width:560px;">
                        <h3 style="margin-top:0.5rem;margin-bottom:.75rem;font-size:1rem;">Ganti Password</h3>
                        <form action="/profile/change-password" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="current_password">Password Saat Ini</label>
                                <input type="password" name="current_password" id="current_password" required style="width:100%;">
                            </div>
                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" name="new_password" id="new_password" required style="width:100%;">
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" required style="width:100%;">
                            </div>
                            <div style="display:flex;gap:.5rem;justify-content:flex-end;margin-top:.5rem;">
                                <button type="submit" class="btn btn-primary">Ganti Password</button>
                                <a href="#" id="cancel-security-btn" class="btn btn-success" style="background:#6c757d;">Batalkan</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>

<style>
    body {
        background-image: none !important;
        background-color: #fff;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const changeBtn = document.getElementById('change-password-btn');
        const editBtn = document.getElementById('edit-profile-btn');
        const cancelSecurityBtn = document.getElementById('cancel-security-btn');
        const securityCard = document.getElementById('security-card');
        const infoCard = document.getElementById('info-card');
        const nameInput = document.getElementById('name-input');
        const profileActions = document.getElementById('profile-actions');
        const saveNameBtn = document.getElementById('save-name-btn');
        const cancelEditBtn = document.getElementById('cancel-edit-btn');

        let originalName = nameInput ? nameInput.value : '';

        // initialize: info is visible, so Edit should be enabled, Change is blue/enabled
        if (editBtn) {
            editBtn.disabled = false;
            editBtn.classList.add('btn-primary');
            editBtn.style.background = '';
            editBtn.style.color = '';
        }
        if (changeBtn) {
            changeBtn.disabled = false;
            changeBtn.classList.add('btn-primary');
            changeBtn.style.background = '';
            changeBtn.style.color = '';
        }

        if (changeBtn) {
            changeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (!securityCard || !infoCard) return;
                // show security, hide info
                securityCard.style.display = 'block';
                infoCard.style.display = 'none';
                // disable and gray out change button; enable edit as blue
                changeBtn.disabled = true;
                changeBtn.classList.remove('btn-primary');
                changeBtn.style.background = '#6c757d';
                changeBtn.style.color = '#fff';
                if (editBtn) {
                    editBtn.disabled = false;
                    editBtn.classList.add('btn-primary');
                    editBtn.style.background = '';
                    editBtn.style.color = '';
                }
            });
        }

        if (cancelSecurityBtn) {
            cancelSecurityBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (!securityCard || !infoCard) return;
                // hide security, show info
                securityCard.style.display = 'none';
                infoCard.style.display = 'block';
                // enable and highlight change button, and enable edit
                if (changeBtn) {
                    changeBtn.disabled = false;
                    changeBtn.classList.add('btn-primary');
                    changeBtn.style.background = '';
                    changeBtn.style.color = '';
                }
                if (editBtn) {
                    editBtn.disabled = false;
                    editBtn.classList.add('btn-primary');
                    editBtn.style.background = '';
                    editBtn.style.color = '';
                }
            });
        }

        if (editBtn) {
            editBtn.addEventListener('click', function (e) {
                e.preventDefault();
                // Enable name input and show Save/Cancel
                if (nameInput) {
                    nameInput.disabled = false;
                    nameInput.focus();
                }
                if (profileActions) {
                    profileActions.style.display = 'flex';
                }
                // Disable edit button while editing
                editBtn.disabled = true;
                editBtn.classList.remove('btn-primary');
                editBtn.style.background = '#6c757d';
                editBtn.style.color = '#fff';
            });
        }

        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', function (e) {
                e.preventDefault();
                // Restore original name and disable input
                if (nameInput) {
                    nameInput.value = originalName;
                    nameInput.disabled = true;
                }
                if (profileActions) {
                    profileActions.style.display = 'none';
                }
                // Enable edit button again
                if (editBtn) {
                    editBtn.disabled = false;
                    editBtn.classList.add('btn-primary');
                    editBtn.style.background = '';
                    editBtn.style.color = '';
                }
            });
        }

        // saveNameBtn is a submit button inside the form; we let the form submit normally.
    });
</script>
