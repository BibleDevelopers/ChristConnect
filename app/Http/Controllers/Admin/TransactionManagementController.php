<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionManagementController extends Controller
{
    public function index(Request $request)
    {
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
