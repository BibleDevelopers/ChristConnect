<x-app class="dashboard-background">
    <div class="dashboard-container">
        <div class="donations-wrapper">
            <div class="dashboard-card" style="max-width:1200px;margin:0 auto;">
                <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;">
                    <div>
                        <h1 style="margin:0;font-size:1.5rem;">Donation Details: {{ $donation->title }}</h1>
                        <p style="margin:.5rem 0 0 0;color:#666;">View all donation transactions for this campaign.</p>
                    </div>
                    <div>
                        <a href="{{ route('donations.index') }}" class="btn">Back</a>
                    </div>
                </div>
            </div>

            <div class="dashboard-card" style="max-width:1200px;margin:1rem auto 0;">
                <div style="background:#f0f9ff;padding:1rem;border-radius:6px;margin-bottom:1rem;border-left:4px solid #0ea5e9;">
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;">
                        <div>
                            <p style="margin:0;color:#0c4a6e;font-size:.9rem;">Target Amount</p>
                            <p style="margin:.25rem 0 0 0;font-weight:700;color:#0b61a4;font-size:1.1rem;">Rp{{ number_format($donation->goal_amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p style="margin:0;color:#0c4a6e;font-size:.9rem;">Total Collected</p>
                            <p style="margin:.25rem 0 0 0;font-weight:700;color:#10b981;font-size:1.1rem;">Rp{{ number_format($donation->collected_amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p style="margin:0;color:#0c4a6e;font-size:.9rem;">Total Donors</p>
                            <p style="margin:.25rem 0 0 0;font-weight:700;color:#6366f1;font-size:1.1rem;">{{ $transactions->total() }} donations</p>
                        </div>
                    </div>
                </div>

                <h3 style="margin-top:1rem;margin-bottom:.75rem;">Donation Transactions</h3>

                @if($transactions->isEmpty())
                    <p style="color:#666;text-align:center;padding:2rem 0;">No donations yet for this campaign.</p>
                @else
                    <div style="overflow-x:auto;">
                        <table style="width:100%;border-collapse:collapse;">
                            <thead>
                                <tr style="background:#f7f7f7;">
                                    <th style="padding:.75rem;text-align:left;border-bottom:2px solid #e5e7eb;">Donor Name</th>
                                    <th style="padding:.75rem;text-align:left;border-bottom:2px solid #e5e7eb;">Email</th>
                                    <th style="padding:.75rem;text-align:right;border-bottom:2px solid #e5e7eb;">Amount</th>
                                    <th style="padding:.75rem;text-align:left;border-bottom:2px solid #e5e7eb;">Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $txn)
                                    <tr style="border-bottom:1px solid #f0f0f0;">
                                        <td style="padding:.75rem;">
                                            <strong>{{ optional($txn->user)->name ?? 'Unknown' }}</strong>
                                        </td>
                                        <td style="padding:.75rem;color:#666;">
                                            {{ optional($txn->user)->email ?? '-' }}
                                        </td>
                                        <td style="padding:.75rem;text-align:right;">
                                            <span style="color:#10b981;font-weight:600;">
                                                Rp{{ number_format(abs($txn->amount), 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td style="padding:.75rem;color:#666;">
                                            {{ $txn->created_at->format('d M Y, H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div style="margin-top:1rem;">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app>
