<x-app class="dashboard-background">
    <div class="dashboard-container">
        <div style="margin-bottom:1rem;">
            <a href="{{ route('renungan') }}" class="btn" style="background:transparent;padding:0;color:#333;">← Back</a>
        </div>

        <div class="dashboard-card" style="max-width:900px;margin:0 auto;">
            @php
                $userBadge = optional($renungan->user)->badges->first();
                $badgeImg = null;
                if ($userBadge) {
                    $b = strtolower($userBadge->name ?? '');
                    if (Str::contains($b, 'bronze')) {
                        $badgeImg = Vite::asset('resources/images/bronze.png');
                    } elseif (Str::contains($b, 'silver')) {
                        $badgeImg = Vite::asset('resources/images/silver.png');
                    } elseif (Str::contains($b, 'gold')) {
                        $badgeImg = Vite::asset('resources/images/gold.png');
                    } elseif (Str::contains($b, 'platinum')) {
                        $badgeImg = Vite::asset('resources/images/platinum.png');
                    }
                }
            @endphp
            <div style="display:flex;gap:1rem;align-items:center;">
                <div class="avatar" style="width:64px;height:64px;border-radius:50%;background:#f3f4f6;display:flex;align-items:center;justify-content:center;font-weight:700;color:#555;font-size:1.25rem;">
                    {{ strtoupper(substr(optional($renungan->user)->name ?? 'U',0,1)) }}
                </div>
                <div style="flex:1;">
                    <h1 style="margin:0;font-size:1.5rem;">{{ $renungan->title }}</h1>
                    <div style="color:#666;font-size:.95rem;margin-top:.25rem;display:flex;align-items:center;gap:0.5rem;">
                        <span>by <strong>{{ optional($renungan->user)->name ?? 'Unknown' }}</strong></span>
                        @if($badgeImg)
                            <img src="{{ $badgeImg }}" alt="Badge" style="width:24px;height:24px;border-radius:4px;" title="{{ $userBadge->name }}">
                        @endif
                        &nbsp;—&nbsp; {{ $renungan->created_at->format('d M Y H:i') }}
                    </div>
                </div>
                <div style="display:flex;gap:.5rem;align-items:center;">
                    @if(auth()->check() && (auth()->id() === $renungan->user_id || auth()->user()->role === 'admin'))
                        <a href="{{ route('renungan.edit', $renungan) }}" class="btn">Edit</a>
                        <form method="post" action="{{ route('renungan.destroy', $renungan) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background:#ff6b6b;color:#fff;" onclick="return confirm('Delete this devotional?')">Delete</button>
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
                        <h3 style="margin-top:0;margin-bottom:.75rem;">Comments</h3>

                @if(session('success'))
                    <div style="background:#e6ffed;border-left:4px solid #5cb85c;color:#1e4620;padding:.6rem;margin-bottom:1rem;">{{ session('success') }}</div>
                @endif

                @if($comments->isEmpty())
                    <p style="color:#666;">No comments yet. Be the first to respond.</p>
                @else
                    <div style="display:flex;flex-direction:column;gap:.75rem;">
                        @foreach($comments as $comment)
                            @php
                                $commentUserBadge = optional($comment->user)->badges->first();
                                $commentBadgeImg = null;
                                if ($commentUserBadge) {
                                    $cb = strtolower($commentUserBadge->name ?? '');
                                    if (Str::contains($cb, 'bronze')) {
                                        $commentBadgeImg = Vite::asset('resources/images/bronze.png');
                                    } elseif (Str::contains($cb, 'silver')) {
                                        $commentBadgeImg = Vite::asset('resources/images/silver.png');
                                    } elseif (Str::contains($cb, 'gold')) {
                                        $commentBadgeImg = Vite::asset('resources/images/gold.png');
                                    } elseif (Str::contains($cb, 'platinum')) {
                                        $commentBadgeImg = Vite::asset('resources/images/platinum.png');
                                    }
                                }
                            @endphp
                            <div style="padding:.75rem;border:1px solid #eef2f6;border-radius:6px;background:#fff;">
                                <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem;">
                                    <div style="display:flex;align-items:center;gap:0.5rem;">
                                        <strong>{{ optional($comment->user)->name ?? 'User' }}</strong>
                                        @if($commentBadgeImg)
                                            <img src="{{ $commentBadgeImg }}" alt="Badge" style="width:18px;height:18px;border-radius:4px;" title="{{ $commentUserBadge->name }}">
                                        @endif
                                        <div style="color:#888;font-size:.85rem;">{{ $comment->created_at->diffForHumans() }}</div>
                                    </div>
                                    @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->role === 'admin'))
                                        <form method="post" action="{{ route('renungan.comment.destroy', [$renungan, $comment]) }}" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn" style="background:transparent;color:#c0392b;" onclick="return confirm('Delete this comment?')">Delete</button>
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
                            <textarea name="content" rows="4" placeholder="Write a comment..." style="width:100%;padding:.5rem;border:1px solid #d1d5db;border-radius:6px;">{{ old('content') }}</textarea>
                            @if($errors->first('content'))<div style="color:#c0392b;">{{ $errors->first('content') }}</div>@endif
                            <div style="display:flex;justify-content:flex-end;gap:.5rem;">
                                <button type="submit" class="btn btn-primary">Post Comment</button>
                            </div>
                        </div>
                    </form>
                @else
                    <p style="color:#666;">Please <a href="{{ route('login') }}">login</a> to leave a comment.</p>
                @endauth
            </div>
        </div>
    </div>
</x-app>
