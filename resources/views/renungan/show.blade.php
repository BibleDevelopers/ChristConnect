<x-app class="dashboard-background">
    <div class="dashboard-container">
        <div style="margin-bottom:1rem;">
            <a href="{{ route('renungan') }}" class="btn" style="background:transparent;padding:0;color:#333;">← Kembali</a>
        </div>

        <div class="dashboard-card" style="max-width:900px;margin:0 auto;">
            <div style="display:flex;gap:1rem;align-items:center;">
                <div class="avatar" style="width:64px;height:64px;border-radius:50%;background:#f3f4f6;display:flex;align-items:center;justify-content:center;font-weight:700;color:#555;font-size:1.25rem;">
                    {{ strtoupper(substr(optional($renungan->user)->name ?? 'U',0,1)) }}
                </div>
                <div style="flex:1;">
                    <h1 style="margin:0;font-size:1.5rem;">{{ $renungan->title }}</h1>
                    <div style="color:#666;font-size:.95rem;margin-top:.25rem;">
                        oleh <strong>{{ optional($renungan->user)->name ?? 'Unknown' }}</strong>
                        &nbsp;—&nbsp; {{ $renungan->created_at->format('d M Y H:i') }}
                    </div>
                </div>
                <div style="display:flex;gap:.5rem;align-items:center;">
                    @if(auth()->check() && (auth()->id() === $renungan->user_id || auth()->user()->role === 'admin'))
                        <a href="{{ route('renungan.edit', $renungan) }}" class="btn">Edit</a>
                        <form method="post" action="{{ route('renungan.destroy', $renungan) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background:#ff6b6b;color:#fff;" onclick="return confirm('Hapus renungan ini?')">Hapus</button>
                        </form>
                    @endif
                </div>
            </div>

            <hr style="margin:1rem 0;">

            <div class="renungan-content" style="line-height:1.8;color:#222;">
                {!! nl2br(e($renungan->content)) !!}
            </div>
        </div>

        <div style="max-width:900px;margin:1.25rem auto 0;">
            <div class="dashboard-card">
                <h3 style="margin-top:0;margin-bottom:.75rem;">Komentar</h3>

                @if(session('success'))
                    <div style="background:#e6ffed;border-left:4px solid #5cb85c;color:#1e4620;padding:.6rem;margin-bottom:1rem;">{{ session('success') }}</div>
                @endif

                @if($comments->isEmpty())
                    <p style="color:#666;">Belum ada komentar. Jadilah yang pertama memberi tanggapan.</p>
                @else
                    <div style="display:flex;flex-direction:column;gap:.75rem;">
                        @foreach($comments as $comment)
                            <div style="padding:.75rem;border:1px solid #eef2f6;border-radius:6px;background:#fff;">
                                <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem;">
                                    <div>
                                        <strong>{{ optional($comment->user)->name ?? 'User' }}</strong>
                                        <div style="color:#888;font-size:.85rem;">{{ $comment->created_at->diffForHumans() }}</div>
                                    </div>
                                    @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->role === 'admin'))
                                        <form method="post" action="{{ route('renungan.comment.destroy', [$renungan, $comment]) }}" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn" style="background:transparent;color:#c0392b;" onclick="return confirm('Hapus komentar ini?')">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                                <p style="margin-top:.5rem;color:#222;">{{ e($comment->content) }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <hr style="margin:1rem 0;">

                @auth
                    <form method="post" action="{{ route('renungan.comment', ['renungan' => $renungan->id]) }}">
                        @csrf
                        <div style="display:flex;flex-direction:column;gap:.5rem;">
                            <textarea name="content" rows="4" placeholder="Tulis komentar..." style="width:100%;padding:.5rem;border:1px solid #d1d5db;border-radius:6px;">{{ old('content') }}</textarea>
                            @if($errors->first('content'))<div style="color:#c0392b;">{{ $errors->first('content') }}</div>@endif
                            <div style="display:flex;justify-content:flex-end;gap:.5rem;">
                                <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                            </div>
                        </div>
                    </form>
                @else
                    <p style="color:#666;">Silakan <a href="{{ route('login') }}">login</a> untuk meninggalkan komentar.</p>
                @endauth
            </div>
        </div>
    </div>
</x-app>
