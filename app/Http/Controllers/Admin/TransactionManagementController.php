<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionManagementController extends Controller
{
    public function index(Request $request)
    {
        $current = Auth::user();
        if (!$current || $current->role !== 'admin') {
            Log::warning('Unauthorized transactions index access attempt', ['user_id' => $current->id ?? null, 'ip' => $request->ip()]);
            abort(403);
        }

        $search = $request->query('q');

        $transactions = Transaction::with('user')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', fn ($q) => $q->where('email', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.transactions.index', compact('transactions', 'search'));
    }
}
