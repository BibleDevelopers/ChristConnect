<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $current = Auth::user();
        if (!$current || $current->role !== 'admin') {
            Log::warning('Unauthorized admin index access attempt', ['user_id' => $current->id ?? null, 'ip' => request()->ip()]);
            abort(403);
        }

        $search = $request->query('q');

        $users = User::with('wallet')
            ->when($search, fn ($query) => $query->where('email', 'like', "%{$search}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }

    public function destroy(User $user)
    {
        $current = Auth::user();
        if (!$current || $current->role !== 'admin') {
            Log::warning('Unauthorized admin destroy attempt', ['user_id' => $current->id ?? null, 'target_user_id' => $user->id ?? null, 'ip' => request()->ip()]);
            abort(403);
        }

        if ($current->id === $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        // Prevent deletion of other admins by non-superadmin
        if ($user->role === 'admin') {
            Log::warning('Attempt to delete admin user blocked', ['by' => $current->id, 'target' => $user->id]);
            return redirect()->route('admin.users.index')->with('error', 'Tidak diizinkan menghapus akun admin lain.');
        }

        $user->delete();

        Log::info('Admin deleted user', ['by' => $current->id, 'deleted_user' => $user->id]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
