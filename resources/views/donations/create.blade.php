<x-app class="dashboard-background">
    <div class="dashboard-container">
        <div class="donations-wrapper">
        <div class="dashboard-card" style="max-width:1000px;margin:0 auto;">
            <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;">
                <div>
                    <h1 style="margin:0;font-size:1.5rem;">Create Donation Campaign</h1>
                    <p style="margin:.5rem 0 0 0;color:#666;">Fill in your donation campaign details below.</p>
                </div>
                <div>
                    <a href="{{ route('donations.index') }}" class="btn">Back</a>
                </div>
            </div>
        </div>

    <div class="dashboard-card" style="max-width:1000px;margin:1rem auto 0;">
            @if(session('error'))
                <div style="background:#fff4f4;border-left:4px solid #ff6b6b;color:#5a2121;padding:.6rem;margin-bottom:1rem;">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div style="background:#fff4f4;border-left:4px solid #ff6b6b;color:#5a2121;padding:.6rem;margin-bottom:1rem;">
                    <ul style="margin:0;padding-left:1.2rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('donations.store') }}" method="POST" style="width:100%;">
                @csrf

                <div style="display:flex;flex-direction:column;gap:.75rem;">
                    <div>
                        <label style="font-weight:600;display:block;margin-bottom:.25rem;">Donation Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required style="width:100%;padding:.5rem;border:1px solid #d1d5db;border-radius:6px;background:#fafafa;">
                        @if($errors->first('title'))<div style="color:#c0392b;font-size:.85rem;margin-top:.25rem;">{{ $errors->first('title') }}</div>@endif
                    </div>

                    <div>
                        <label style="font-weight:600;display:block;margin-bottom:.25rem;">Description</label>
                        <textarea name="description" class="form-control" rows="4" style="width:100%;padding:.5rem;border:1px solid #d1d5db;border-radius:6px;background:#fff;">{{ old('description') }}</textarea>
                        @if($errors->first('description'))<div style="color:#c0392b;font-size:.85rem;margin-top:.25rem;">{{ $errors->first('description') }}</div>@endif
                    </div>

                    <div>
                        <label style="font-weight:600;display:block;margin-bottom:.25rem;">Target Amount (Rp)</label>
                        <input type="number" name="goal_amount" class="form-control" value="{{ old('goal_amount') }}" required min="0" style="width:100%;padding:.5rem;border:1px solid #d1d5db;border-radius:6px;background:#fafafa;">
                        @if($errors->first('goal_amount'))<div style="color:#c0392b;font-size:.85rem;margin-top:.25rem;">{{ $errors->first('goal_amount') }}</div>@endif
                    </div>

                        <div style="display:flex;justify-content:flex-end;gap:.5rem;margin-top:1rem;">
                        <a href="{{ route('donations.index') }}" class="btn" style="background:#6c757d;color:#fff;">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Donation</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app>
