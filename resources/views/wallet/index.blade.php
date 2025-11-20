<x-app>
    <style>
        body { background:#fff !important; }
        .wallet-container { max-width:900px;margin:2rem auto;padding:1.5rem; }
        .wallet-balance { background:#f7f9ff;padding:2rem;border-radius:12px;text-align:center;margin-bottom:2rem;border:1px solid #e0e0e0; }
        .wallet-balance h2 { margin:0;font-size:2.5rem;color:#2563eb; }
        .wallet-actions { display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem; }
        .wallet-card { background:#fff;padding:1.5rem;border:1px solid #e5e7eb;border-radius:12px; }
        .wallet-card h3 { margin-top:0; }
        .wallet-card input { width:100%;padding:0.75rem;border:1px solid #ccc;border-radius:6px;margin-bottom:1rem; }
        .wallet-card button { width:100%;padding:0.75rem;border:none;border-radius:6px;font-weight:600;cursor:pointer; }
        .btn-topup { background:#10b981;color:#fff; }
        .btn-withdraw { background:#ef4444;color:#fff; }
        .transactions-list { background:#fff;padding:1.5rem;border:1px solid #e5e7eb;border-radius:12px; }
        .transaction-item { padding:0.75rem;border-bottom:1px solid #f0f0f0;display:flex;justify-content:space-between; }
        .amount-positive { color:#10b981;font-weight:600; }
        .amount-negative { color:#ef4444;font-weight:600; }
    </style>

    <div class="wallet-container">
        <h1>My Wallet</h1>

        @if(session('success'))
            <div class="alert alert-success" style="background:#e6ffed;padding:1rem;border-radius:8px;margin-bottom:1rem;border-left:4px solid #10b981;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" style="background:#fff4f4;padding:1rem;border-radius:8px;margin-bottom:1rem;border-left:4px solid #ef4444;">
                {{ session('error') }}
            </div>
        @endif

        <div class="wallet-balance">
            <p style="margin:0;color:#666;font-size:0.9rem;">Saldo Saat Ini</p>
            <h2>Rp{{ number_format(optional($user->wallet)->balance ?? 0, 0, ',', '.') }}</h2>
        </div>

        <div class="wallet-actions">
            <div class="wallet-card">
                <h3>Top-up Saldo</h3>
                <form method="POST" action="{{ route('wallet.topup') }}">
                    @csrf
                    <input type="number" name="amount" min="10000" max="10000000" step="1000" 
                           placeholder="Minimal Rp10.000" required>
                    @if($errors->topup->first('amount'))
                        <div style="color:#ef4444;font-size:0.875rem;margin-top:-0.5rem;margin-bottom:0.5rem;">
                            {{ $errors->topup->first('amount') }}
                        </div>
                    @endif
                    <button type="submit" class="btn-topup">Top-up Sekarang</button>
                </form>
            </div>

            <div class="wallet-card">
                <h3>Tarik Saldo</h3>
                <form method="POST" action="{{ route('wallet.withdraw') }}">
                    @csrf
                    <input type="number" name="amount" min="10000" step="1000" 
                           placeholder="Minimal Rp10.000" required>
                    @if($errors->withdraw->first('amount'))
                        <div style="color:#ef4444;font-size:0.875rem;margin-top:-0.5rem;margin-bottom:0.5rem;">
                            {{ $errors->withdraw->first('amount') }}
                        </div>
                    @endif
                    <button type="submit" class="btn-withdraw" onclick="return confirm('Yakin ingin menarik saldo?')">
                        Tarik Saldo
                    </button>
                </form>
            </div>
        </div>

        <div class="transactions-list">
            <h3>Riwayat Transaksi</h3>
            @forelse($transactions as $txn)
                <div class="transaction-item">
                    <div>
                        <strong>{{ ucfirst($txn->type) }}</strong>
                        <p style="margin:0.25rem 0 0 0;font-size:0.875rem;color:#666;">
                            {{ $txn->description }} • {{ $txn->created_at->format('d M Y H:i') }}
                        </p>
                    </div>
                    <div class="{{ $txn->amount >= 0 ? 'amount-positive' : 'amount-negative' }}">
                        {{ $txn->amount >= 0 ? '+' : '' }}Rp{{ number_format(abs($txn->amount), 0, ',', '.') }}
                    </div>
                </div>
            @empty
                <p style="color:#666;text-align:center;padding:2rem 0;">Belum ada transaksi.</p>
            @endforelse

            <div style="margin-top:1rem;">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</x-app>
