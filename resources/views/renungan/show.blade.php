<x-app>
    <style>
        body {
            background-image: none !important;
            background-color: #fff;
        }
    </style>

    <a href="{{ route('renungan') }}">← Kembali</a>
    <h1>{{ $renungan->title }}</h1>
    <p>oleh {{ optional($renungan->user)->name ?? 'Unknown' }} — {{ $renungan->created_at->format('d M Y H:i') }}</p>

    <div>
        {{ nl2br(e($renungan->content)) }}
    </div>

    @if(auth()->id() === $renungan->user_id || auth()->user()->role === 'admin')
        <form method="post" action="{{ route('renungan.destroy', $renungan) }}" style="margin:1rem 0;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Hapus renungan ini?')">Hapus Renungan</button>
        </form>
    @endif

    <hr>
    <h3>Komentar</h3>

    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    @foreach($comments as $comment)
        <div style="margin-bottom:1rem;">
            <strong>{{ optional($comment->user)->name ?? 'User' }}</strong>
            <small>{{ $comment->created_at->diffForHumans() }}</small>
            <p>{{ e($comment->content) }}</p>

            @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                <form method="post" action="{{ route('renungan.comment.destroy', [$renungan, $comment]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Hapus komentar ini?')">Hapus Komentar</button>
                </form>
            @endif
        </div>
    @endforeach

    <!-- form komentar -->
    <form method="post" action="{{ route('renungan.comment', ['renungan' => $renungan->id]) }}">
        @csrf
        <div>
            <textarea name="content" placeholder="Tulis komentar...">{{ old('content') }}</textarea>
            @if($errors->first('content'))<div style="color:red;">{{ $errors->first('content') }}</div>@endif
        </div>
        <button type="submit">Kirim Komentar</button>
    </form>
</x-app>
