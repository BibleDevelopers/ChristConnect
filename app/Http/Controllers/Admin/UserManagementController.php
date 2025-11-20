<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');

        $users = User::with('wallet')
            ->when($search, fn ($query) => $query->where('email', 'like', "%{$search}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }
}
