<x-app class="dashboard-background">
    <div class="dashboard-container">
        <div class="dashboard-card" style="max-width:900px;margin:0 auto 1rem;">
            <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;">
                <div>
                    <h1 style="margin:0;font-size:1.5rem;">Renungan Harian</h1>
                    <p style="margin:.25rem 0 0 0;color:#666;">Isi judul dan renunganmu, lalu tekan tombol <strong>Kirim Renungan</strong> di bawah.</p>
                </div>
                <div>
                    <a href="/" class="btn">Beranda</a>
                </div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr;gap:20px;max-width:1100px;margin:0 auto;">
            <div class="dashboard-card">
                <h2 style="margin-top:0">Buat Renungan Baru</h2>

                @if(session('success'))
                    <div style="background:#e6ffed;border-left:4px solid #5cb85c;color:#1e4620;padding:.6rem;margin-bottom:1rem;">{{ session('success') }}</div>
                @endif

                <form class="renungan-form" method="post" action="{{ route('renungan.store') }}">
                    @csrf
                    <div style="display:flex;flex-direction:column;gap:.5rem;">
                        <label style="font-weight:600;">Judul</label>
                        <input type="text" name="title" value="{{ old('title') }}" style="width:100%;padding:.5rem;border:1px solid #d1d5db;border-radius:6px;background:#fafafa;">
                        @if($errors->first('title'))<div style="color:#c0392b;">{{ $errors->first('title') }}</div>@endif

                        <label style="font-weight:600;margin-top:.5rem;">Isi</label>
                        <textarea name="content" rows="8" style="width:100%;padding:.5rem;border:1px solid #d1d5db;border-radius:6px;background:#fff;">{{ old('content') }}</textarea>
                        @if($errors->first('content'))<div style="color:#c0392b;">{{ $errors->first('content') }}</div>@endif

                        <div style="display:flex;justify-content:flex-end;margin-top:.5rem;">
                            <button type="submit" class="btn btn-primary">Kirim Renungan</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="dashboard-card">
                <h2 style="margin-top:0">Daftar Renungan</h2>

                @if($posts->isEmpty())
                    <p style="color:#666;">Belum ada renungan. Jadilah yang pertama untuk mengirim.</p>
                @else
                    <div style="display:flex;flex-direction:column;gap:1rem;">
                        @foreach($posts as $post)
                            <div style="padding:1rem;border:1px solid #eef2f6;border-radius:6px;background:#fff;display:flex;justify-content:space-between;gap:1rem;align-items:flex-start;">
                                <div style="flex:1;">
                                    <a href="{{ route('renungan.show', ['renungan' => $post->id]) }}" style="font-size:1.05rem;font-weight:600;color:#0b61a4;">{{ $post->title }}</a>
                                    <div style="color:#666;font-size:.9rem;margin-top:.25rem;">oleh <strong>{{ optional($post->user)->name ?? 'Unknown' }}</strong> — {{ $post->created_at->diffForHumans() }}</div>
                                    <p style="margin-top:.5rem;color:#333;">{{ Str::limit($post->content, 220) }}</p>
                                </div>
                                <div style="display:flex;flex-direction:column;gap:.5rem;align-items:flex-end;">
                                    @if(auth()->check() && (auth()->id() === $post->user_id || auth()->user()->role === 'admin'))
                                        <a href="{{ route('renungan.edit', $post) }}" class="btn">Edit</a>
                                        <form method="post" action="{{ route('renungan.destroy', $post) }}" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn" style="background:#ff6b6b;color:#fff;" onclick="return confirm('Hapus renungan ini?')">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="margin-top:1rem;display:flex;justify-content:center;">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app>
