<x-app class="admin-background">
    <style>
        .admin-users-card { max-width:1000px;margin:2rem auto;padding:1.5rem;border:1px solid #e5e7eb;border-radius:12px;background:#fff; }
        .admin-users-card table { width:100%;border-collapse:collapse;margin-top:1rem; }
        .admin-users-card th, .admin-users-card td { padding:0.75rem;border-bottom:1px solid #f0f0f0;text-align:left; }
        .admin-users-card th { background:#f7f7f7;font-weight:600; }
        .trash-btn { background:none;border:none;cursor:pointer;color:#dc2626;font-size:1.25rem; }
        .trash-btn:hover { color:#991b1b; }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="admin-users-card">
        <h1>Manage Users</h1>

        @if(session('success'))
            <div class="alert alert-success" style="margin-top:1rem;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" style="margin-top:1rem;">{{ session('error') }}</div>
        @endif

        <form method="get" action="{{ route('admin.users.index') }}" style="display:flex;gap:0.5rem;margin-top:1rem;">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search by email..."
                   style="flex:1;padding:0.5rem;border:1px solid #ccc;border-radius:6px;">
            <button type="submit" class="btn btn-primary" style="padding:0.5rem 1.25rem;">Search</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Wallet Balance</th>
                    <th>Joined</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role ?? '-' }}</td>
                        <td>Rp{{ number_format(optional($user->wallet)->balance ?? 0, 0, ',', '.') }}</td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            @if(auth()->id() !== $user->id)
                                <form method="post" action="{{ route('admin.users.destroy', $user) }}"
                                    onsubmit="return confirm('Delete this user?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="trash-btn" title="Delete user">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <small class="text-muted">(current)</small>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:1rem;">
            {{ $users->links() }}
        </div>
    </div>
</x-app>

{{-- view di-nonaktifkan sementara --}}
