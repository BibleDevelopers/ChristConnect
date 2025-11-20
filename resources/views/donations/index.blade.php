<x-app class="donations-page">
    <div class="container mt-5">
        <h1 class="donation-title">Donation Boxes</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (Auth::user()->role === 'admin')
            <div class="add-donation-container">
                <a href="{{ route('donations.create') }}" class="btn add-donation-btn mb-3">+ Add Donation Box</a>
            </div>
        @endif

        <div class="donations-grid">
            @foreach ($donations as $donation)
                <div class="card">
                    <div class="card-body">
                        <h3>{{ $donation->title }}</h3>
                        <p>{{ $donation->description }}</p>
                        <p><strong>Goal:</strong> {{ number_format($donation->goal_amount, 2) }}</p>
                        <p><strong>Collected:</strong> {{ number_format($donation->collected_amount, 2) }}</p>

                        @if (Auth::user()->role === 'user')
                            <form method="POST" action="{{ route('donations.donate', $donation->id) }}">
                                @csrf
                                <label class="form-label">Masukkan jumlah donasi</label>
                                <input
                                    type="number"
                                    name="amount"
                                    min="1000"
                                    max="1000000000"
                                    inputmode="numeric"
                                    step="100"
                                    class="form-control mb-2"
                                    placeholder="Contoh: 50000"
                                    required
                                >
                                <button class="btn btn-success w-100">Donate</button>
                            </form>
                        @endif

                        @auth
                            @if (auth()->user()->role === 'admin')
                                <div class="mt-2 d-flex gap-2">
                                    <a href="{{ route('donations.edit', $donation) }}" class="manage-btn">Manage</a>
                                    <form method="POST" action="{{ route('donations.destroy', $donation) }}"
                                          onsubmit="return confirm('Hapus kotak donasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app>
