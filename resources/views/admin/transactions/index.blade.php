<x-app class="admin-background">
    <style>
        .admin-transactions-card { max-width:1200px;margin:2rem auto;padding:1.5rem;border:1px solid #e5e7eb;border-radius:12px;background:#fff; }
        .admin-transactions-card table { width:100%;border-collapse:collapse;margin-top:1rem; }
        .admin-transactions-card th, .admin-transactions-card td { padding:0.75rem;border-bottom:1px solid #f0f0f0;text-align:left; }
        .admin-transactions-card th { background:#f7f7f7;font-weight:600; }
    </style>

    <div class="admin-transactions-card">
        <h1>Manage Transactions</h1>

        <form method="get" action="{{ route('admin.transactions.index') }}" style="display:flex;gap:0.5rem;margin-top:1rem;">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search by user email..."
                   style="flex:1;padding:0.5rem;border:1px solid #ccc;border-radius:6px;">
            <button type="submit" class="btn btn-primary" style="padding:0.5rem 1.25rem;">Search</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $txn)
                    <tr>
                        <td>{{ $txn->id }}</td>
                        <td>{{ optional($txn->user)->name ?? '-' }}</td>
                        <td>{{ optional($txn->user)->email ?? '-' }}</td>
                        <td>{{ $txn->type }}</td>
                        <td style="color:{{ $txn->amount < 0 ? 'red' : 'green' }};">
                            Rp{{ number_format(abs($txn->amount), 0, ',', '.') }}
                        </td>
                        <td>{{ $txn->description ?? '-' }}</td>
                        <td>{{ $txn->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:1rem;">
            {{ $transactions->links() }}
        </div>
    </div>
</x-app>
