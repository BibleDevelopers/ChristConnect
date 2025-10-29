<x-app class="donations-page">
    <div class="container mt-5">
        <h1 class="donation-title">Donation Boxes</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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
                            @if ($donation->options->isEmpty())
                                <form method="POST" action="{{ route('donations.donate', $donation->id) }}">
                                    @csrf
                                    <input type="number" name="amount" placeholder="Enter amount" class="form-control mb-2" required>
                                    <button class="btn btn-success">Donate</button>
                                </form>
                            @else
                                <div class="donation-options">
                                    <label class="form-label mb-2">Choose your donation amount:</label>
                                    <div class="donation-option-grid">
                                        @foreach ($donation->options as $option)
                                            <form method="POST" action="{{ route('donations.donate', $donation->id) }}" class="donation-form">
                                                @csrf
                                                <input type="hidden" name="amount" value="{{ $option->amount }}">
                                                <button type="submit" class="donation-option-btn">
                                                    {{ $option->label ? $option->label . ' : ' : '' }}{{ number_format($option->amount, 0) }}
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif

                        @auth
                            @if (auth()->user()->role === 'admin')
                                <div class="mt-2">
                                    <a href="{{ route('donations.edit', $donation) }}" class="manage-btn">Manage</a>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app>
