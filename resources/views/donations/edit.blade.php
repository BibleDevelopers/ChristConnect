<x-app class="donations-page">
    <div class="container mt-5">
        <h1>Edit Donation Box</h1>

        <form action="{{ route('donations.update', $donation) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $donation->title) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $donation->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Goal Amount</label>
                <input type="number" name="goal_amount" class="form-control" value="{{ old('goal_amount', $donation->goal_amount) }}" required>
            </div>

            <h4>Fixed-price options</h4>
            <p class="text-muted">Edit existing options or add new ones. Deleting will remove the option.</p>

            <div id="options-list">
                @foreach ($donation->options as $i => $option)
                    <div class="option-row mb-2 border rounded p-2" data-index="{{ $i }}">
                        <input type="hidden" name="options[{{ $i }}][id]" value="{{ $option->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Label</label>
                                <input type="text" name="options[{{ $i }}][label]" class="form-control" value="{{ $option->label }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Amount</label>
                                <input type="number" step="0.01" name="options[{{ $i }}][amount]" class="form-control" value="{{ $option->amount }}" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="options[{{ $i }}][_delete]" value="1" id="delete-{{ $option->id }}">
                                    <label class="form-check-label text-danger" for="delete-{{ $option->id }}">Delete</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-option" class="btn btn-outline-primary mb-3">+ Add option</button>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('donations.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        (function(){
            const addBtn = document.getElementById('add-option');
            const list = document.getElementById('options-list');
            let nextIndex = {{ $donation->options->count() }};

            addBtn.addEventListener('click', function(){
                const idx = nextIndex++;
                const wrapper = document.createElement('div');
                wrapper.className = 'option-row mb-2 border rounded p-2';
                wrapper.dataset.index = idx;
                wrapper.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Label</label>
                            <input type="text" name="options[${idx}][label]" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Amount</label>
                            <input type="number" step="0.01" name="options[${idx}][amount]" class="form-control" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-new">Remove</button>
                        </div>
                    </div>
                `;
                list.appendChild(wrapper);

                wrapper.querySelector('.remove-new').addEventListener('click', function(){
                    wrapper.remove();
                });
            });
        })();
    </script>
</x-app>
