<x-app class="dashboard-background">
    <div class="dashboard-container">
        <div class="dashboard-card" style="max-width:900px;margin:0 auto;">
            <h1 style="margin:0;font-size:1.5rem;">Edit Devotional</h1>
            <p style="color:#666;margin-top:.5rem;">Update the title or content of the devotional, then click Save.</p>

            <form method="POST" action="{{ route('renungan.update', $renungan) }}" style="margin-top:1rem;">
                @csrf
                @method('PUT')
                <div style="display:flex;flex-direction:column;gap:.5rem;">
                    <label style="font-weight:600;">Title</label>
                    <input type="text" name="title" value="{{ old('title', $renungan->title) }}" style="width:100%;padding:.5rem;border:1px solid #d1d5db;border-radius:6px;">
                    @if($errors->first('title'))<div style="color:#c0392b;">{{ $errors->first('title') }}</div>@endif

                    <label style="font-weight:600;margin-top:.5rem;">Content</label>
                    <textarea name="content" rows="10" style="width:100%;padding:.5rem;border:1px solid #d1d5db;border-radius:6px;">{{ old('content', $renungan->content) }}</textarea>
                    @if($errors->first('content'))<div style="color:#c0392b;">{{ $errors->first('content') }}</div>@endif

                    <div style="display:flex;justify-content:flex-end;margin-top:.5rem;gap:.5rem;">
                        <a href="{{ route('renungan.show', $renungan) }}" class="btn">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app>
