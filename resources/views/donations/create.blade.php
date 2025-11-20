<x-app class="donations-page">
    <div class="container mt-5">
        <h1>Create Donation Box</h1>

        <form action="{{ route('donations.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Goal Amount</label>
                <input type="number" name="goal_amount" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('donations.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-app>
