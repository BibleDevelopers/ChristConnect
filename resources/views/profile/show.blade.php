<x-app>
    <style>
        body {
            background-image: none !important;
            background-color: #fff;
        }
    </style>

    <section style="max-width:600px;margin:2rem auto;">
        <h1>Profil Saya</h1>

        <div style="margin-bottom:1.5rem;">
            <h3>Informasi Akun</h3>
            <p><strong>Nama:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Email Terverifikasi:</strong> {{ $user->hasVerifiedEmail() ? 'Ya' : 'Belum' }}</p>
            <p><strong>Bergabung Sejak:</strong> {{ $user->created_at->format('d M Y') }}</p>
        </div>

        <div style="margin-bottom:1.5rem;padding:1rem;border:1px solid #ddd;border-radius:8px;background:#f9f9f9;">
            <h3>Wallet Saya</h3>
            @php($balance = optional($user->wallet)->balance ?? 0)
            <p><strong>Saldo:</strong> Rp{{ number_format($balance, 0, ',', '.') }}</p>
            <p><strong>Total Donasi:</strong> Rp{{ number_format($user->total_donated ?? 0, 0, ',', '.') }}</p>
        </div>

        <div>
            <h3>Lencana (Badges)</h3>
            @if($user->badges->isEmpty())
                <p>Belum ada badge. Silakan lanjutkan donasi untuk membuka badge.</p>
            @else
                <ul style="list-style:none;padding:0;">
                    @foreach($user->badges as $badge)
                        <li style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.75rem;">
                            @if($badge->icon_url)
                                <img src="{{ $badge->icon_url }}" alt="{{ $badge->name }}" style="width:40px;height:40px;object-fit:contain;">
                            @endif
                            <div>
                                <strong>{{ $badge->name }}</strong><br>
                                <small>Minimum donasi: Rp{{ number_format($badge->min_donation, 0, ',', '.') }}</small>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>
</x-app>
