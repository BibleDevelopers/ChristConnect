<x-app>
    <style>
        body {
            background-image: none !important;
            background-color: #fff;
        }

        .renungan-form input[type="text"],
        .renungan-form textarea {
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            padding: 0.5rem;
        }
    </style>

    <h1>Renungan Harian</h1>

    <p>Isi judul dan renunganmu, lalu tekan tombol <strong>Kirim Renungan</strong> di bawah.</p>

    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <!-- form buat post baru -->
    <form class="renungan-form" method="post" action="{{ route('renungan.store') }}">
        @csrf
        <div>
            <label>Judul</label><br>
            <input type="text" name="title" value="{{ old('title') }}">
            @if($errors->first('title'))<div style="color:red;">{{ $errors->first('title') }}</div>@endif
        </div>
        <div>
            <label>Isi</label><br>
            <textarea name="content">{{ old('content') }}</textarea>
            @if($errors->first('content'))<div style="color:red;">{{ $errors->first('content') }}</div>@endif
        </div>
        <button type="submit">Kirim Renungan</button>
    </form>

    <hr>

    <!-- daftar post -->
    @foreach($posts as $post)
        <article>
            <h3>
                <a href="{{ route('renungan.show', ['renungan' => $post->id]) }}">{{ $post->title }}</a>
            </h3>
            <p>oleh {{ optional($post->user)->name ?? 'Unknown' }} — {{ $post->created_at->diffForHumans() }}</p>
            <p>{{ Str::limit($post->content, 200) }}</p>

            @if(auth()->id() === $post->user_id || auth()->user()->role === 'admin')
                <form method="post" action="{{ route('renungan.destroy', $post) }}" style="margin-top:0.5rem;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Hapus renungan ini?')">Hapus</button>
                </form>
            @endif
        </article>
        <hr>
    @endforeach

    <!-- pagination -->
    {{ $posts->links() }}
</x-app>
