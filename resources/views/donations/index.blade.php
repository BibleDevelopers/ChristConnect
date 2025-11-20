<x-app class="dashboard-background">
    <div class="dashboard-container">
        <div class="dashboard-card" style="max-width:1000px;margin:0 auto;margin-bottom:1.5rem;">
            <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
                <div>
                    <h1 style="margin:0;font-size:1.5rem;">Kotak Donasi</h1>
                    <p style="margin:.5rem 0 0 0;color:#666;">Lihat dan kelola kotak donasi yang tersedia.</p>
                </div>
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('donations.create') }}" class="btn btn-primary">+ Buat Kotak Donasi</a>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div style="background:#e6ffed;border-left:4px solid #5cb85c;color:#1e4620;padding:.6rem;margin:0 auto 1rem;max-width:1000px;">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div style="background:#fff4f4;border-left:4px solid #ff6b6b;color:#5a2121;padding:.6rem;margin:0 auto 1rem;max-width:1000px;">{{ session('error') }}</div>
        @endif

        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(300px, 1fr));gap:1.5rem;max-width:1200px;margin:0 auto;">
            @foreach ($donations as $donation)
                <div class="dashboard-card" style="padding:1.5rem;display:flex;flex-direction:column;">
                    <div style="flex:1;">
                        <h3 style="margin:0 0 .5rem 0;font-size:1.1rem;color:#0b61a4;">{{ $donation->title }}</h3>
                        <p style="color:#666;margin:0 0 .75rem 0;font-size:.95rem;">{{ Str::limit($donation->description, 100) }}</p>
                        
                        <div style="background:#f3f4f6;padding:.75rem;border-radius:6px;margin-bottom:1rem;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:.5rem;">
                                <span style="color:#666;font-size:.9rem;">Target:</span>
                                <strong style="color:#0b61a4;">Rp{{ number_format($donation->goal_amount, 0, ',', '.') }}</strong>
                            </div>
                            <div style="display:flex;justify-content:space-between;">
                                <span style="color:#666;font-size:.9rem;">Terkumpul:</span>
                                <strong style="color:#5cb85c;">Rp{{ number_format($donation->collected_amount, 0, ',', '.') }}</strong>
                            </div>
                            @php
                                $progress = $donation->goal_amount > 0 ? ($donation->collected_amount / $donation->goal_amount) * 100 : 0;
                            @endphp
                            <div style="width:100%;height:8px;background:#e0e0e0;border-radius:4px;margin-top:.5rem;overflow:hidden;">
                                <div style="height:100%;background:#5cb85c;width:{{ min($progress, 100) }}%;"></div>
                            </div>
                        </div>
                    </div>

                    @if (Auth::user()->role === 'user')
                        <form method="POST" action="{{ route('donations.donate', $donation->id) }}" style="margin-top:auto;">
                            @csrf
                            <div style="display:flex;flex-direction:column;gap:.5rem;">
                                <label style="font-weight:600;font-size:.9rem;">Jumlah Donasi</label>
                                <input
                                    type="number"
                                    name="amount"
                                    min="1000"
                                    max="1000000000"
                                    inputmode="numeric"
                                    step="100"
                                    style="width:100%;padding:.5rem;border:1px solid #d1d5db;border-radius:6px;background:#fafafa;"
                                    placeholder="Contoh: 50000"
                                    required
                                >
                                <button type="submit" class="btn btn-primary" style="width:100%;">Donasi Sekarang</button>
                            </div>
                        </form>
                    @endif

                    @auth
                        @if (auth()->user()->role === 'admin')
                            <div style="margin-top:1rem;display:flex;gap:.5rem;justify-content:flex-end;">
                                <a href="{{ route('donations.edit', $donation) }}" class="btn">Kelola</a>
                            </div>
                        @endif
                    @endauth
                </div>
            @endforeach
        </div>

        @if($donations->isEmpty())
            <div class="dashboard-card" style="max-width:1000px;margin:2rem auto;text-align:center;padding:3rem 1rem;">
                <p style="color:#666;">Belum ada kotak donasi. Jadilah yang pertama untuk membuat.</p>
            </div>
        @endif
    </div>
</x-app>
