<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use App\Models\Donation;

use App\Models\User;
use App\Models\Badge;
use App\Models\Transaction;

class DonationController extends Controller
{
    private BadgeService $badgeService;

    // add middleware enforcement (require auth; admin only for management endpoints)
    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;

        // require authenticated user for all actions
        $this->middleware('auth');

        // restrict admin-only endpoints
        $this->middleware('admin')->only(['create', 'store', 'edit', 'detail', 'update', 'destroy']);
    }

    public function index()
    {
        $donations = Donation::all();
        return view('donations.index', compact('donations'));
    }

    public function create()
    {
        // Create donation box (admin only)
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        return view('donations.create');
    }

    public function store(Request $request)
    {
        // Admin only
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal_amount' => 'required|numeric|min:1',
        ]);

        // sanitize title
        $titleClean = trim(strip_tags($request->title));
        if ($titleClean === '') {
            return back()->withErrors(['title' => 'Title harus berisi teks yang valid.'])->withInput();
        }

        $desc = $request->input('description', '');

        // Prefer a trusted purifier if available
        if (app()->bound('purifier')) {
            $cleanDesc = app('purifier')->clean($desc);
        } else {
            $allowed = '<p><br><strong><em><ul><ol><li><a>';
            $cleanDesc = strip_tags($desc, $allowed);

            // remove inline event handlers (on*)
            $cleanDesc = preg_replace('/(<[a-z][^>]*?)on\w+\s*=\s*([\'"]).*?\2/iu', '$1', $cleanDesc);

            // sanitize hrefs in anchors and add rel/target for external links
            $cleanDesc = preg_replace_callback(
                '/<a\s+[^>]*href=(["\']?)([^"\'>\s]+)\1[^>]*>/i',
                function ($m) {
                    $href = $m[2] ?? '';
                    if (preg_match('/^(https?:\/\/|mailto:|\/)/i', $href)) {
                        $safe = htmlspecialchars($href, ENT_QUOTES, 'UTF-8');
                        $relTarget = preg_match('/^https?:\/\//i', $href) ? ' target="_blank" rel="noopener noreferrer"' : '';
                        return '<a href="' . $safe . '"' . $relTarget . '>';
                    }
                    return '<a>';
                },
                $cleanDesc
            );
        }

        // Reject if sanitization removed all visible text
        if (trim(strip_tags($cleanDesc)) === '') {
            return back()->withErrors(['description' => 'Description kosong atau berisi HTML yang tidak diizinkan.'])->withInput();
        }

        $donation = Donation::create([
            'title' => $titleClean,
            'description' => $cleanDesc,
            'goal_amount' => $request->goal_amount,
            'collected_amount' => 0,
        ]);

        return redirect()->route('donations.index')->with('success', 'Donation box created!');
    }

    public function edit(Donation $donation)
    {
        // Admin only
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        return view('donations.edit', compact('donation'));
    }

    public function detail(Donation $donation)
    {
        $current = Auth::user();

        // Defensive check + audit logging
        if (!$current || $current->role !== 'admin') {
            Log::warning('Unauthorized attempt to view donation detail', [
                'user_id' => $current->id ?? null,
                'donation_id' => $donation->id ?? null,
                'ip' => request()->ip(),
            ]);
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        // Log admin access for audit
        Log::info('Admin viewed donation detail', [
            'admin_id' => $current->id,
            'donation_id' => $donation->id,
            'ip' => request()->ip(),
        ]);

        // Get all donation transactions for this campaign
        $transactions = Transaction::where('donation_id', $donation->id)
            ->where('type', 'donation')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('donations.detail', compact('donation', 'transactions'));
    }

    public function donate(Request $request, Donation $donation)
    {
        // Ensure authenticated user and wallet exist before validating amount
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Auto-create wallet if missing (defensive)
        if (!$user->wallet) {
            try {
                $user->wallet()->create(['balance' => 0]);
                $user->load('wallet');
            } catch (\Throwable $e) {
                \Log::error('Failed to create wallet before donation', ['user_id' => $user->id ?? null, 'error' => $e->getMessage()]);
                return back()->with('error', 'Tidak dapat mengakses dompet Anda saat ini. Silakan coba lagi nanti atau hubungi dukungan.');
            }
        }

        $request->validate([
            'amount' => 'required|integer|min:1000|max:1000000000',
        ]);

        $amount = (int) $request->input('amount');
        if ($amount <= 0) {
            return back()->with('error', 'Jumlah donasi tidak valid.');
        }

        // Rate limiter (defense-in-depth): per-user-per-campaign
        $key = 'donate|' . ($user->id ?? 'guest') . '|' . $donation->id;
        $maxAttempts = 10;
        $decaySeconds = 60; // 1 minute window

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Terlalu banyak percobaan donasi. Coba lagi setelah $seconds detik.");
        }

        // count this attempt; clear on success later
        RateLimiter::hit($key, $decaySeconds);

        try {
            DB::transaction(function () use ($user, $amount, $donation) {

                // 1. Ambil wallet user & KUNCI (agar aman dari double-spending)
                $wallet = $user->wallet()->lockForUpdate()->first();

                // Defensive: ensure wallet exists (again)
                if (!$wallet) {
                    throw new \Exception('Wallet tidak ditemukan. Silakan hubungi dukungan.');
                }

                // 2. Cek Saldo
                if ($wallet->balance < $amount) {
                    // Melempar error ini akan otomatis membatalkan transaksi (rollback)
                    throw new \Exception('Saldo dompet Anda tidak mencukupi.');
                }

                // 3. Kurangi Saldo Wallet
                $wallet->decrement('balance', $amount);

                // 4. Catat di Transactions
                $user->transactions()->create([
                    'donation_id' => $donation->id,
                    'type' => 'donation',
                    'amount' => -$amount, // Minus karena uang keluar
                    'description' => 'Donasi untuk: ' . $donation->title
                ]);

                // 5. Tambah Uang di Kotak Donasi
                // Kita pakai increment() agar aman jika ada 2 donasi bersamaan
                $donation->increment('collected_amount', $amount);

            }); // Transaksi Selesai & Sukses

        } catch (\Exception $e) {
            \Log::error('Donation failed', [
                'user_id' => $user->id ?? null,
                'donation_id' => $donation->id ?? null,
                'amount' => $amount,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses donasi. Silakan coba lagi atau hubungi dukungan.');
        }

        // success → clear attempts so user isn't blocked after valid donation
        RateLimiter::clear($key);

        $user = $request->user();

        if ($user && $amount > 0) {
            $user->increment('total_donated', $amount);
            $user->refresh(); // ensure latest total_donated for badge assignment
            $this->badgeService->syncDonationBadges($user);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('donations.index')->with('success', 'Thank you for your donation!');
    }


    public function update(Request $request, Donation $donation)
    {
        // Admin only
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal_amount' => 'required|numeric|min:1',
        ]);

        // sanitize title
        $titleClean = trim(strip_tags($request->title));
        if ($titleClean === '') {
            return back()->withErrors(['title' => 'Title harus berisi teks yang valid.'])->withInput();
        }

        $desc = $request->input('description', '');

        if (app()->bound('purifier')) {
            $cleanDesc = app('purifier')->clean($desc);
        } else {
            $allowed = '<p><br><strong><em><ul><ol><li><a>';
            $cleanDesc = strip_tags($desc, $allowed);
            $cleanDesc = preg_replace('/(<[a-z][^>]*?)on\w+\s*=\s*([\'"]).*?\2/iu', '$1', $cleanDesc);
            $cleanDesc = preg_replace_callback(
                '/<a\s+[^>]*href=(["\']?)([^"\'>\s]+)\1[^>]*>/i',
                function ($m) {
                    $href = $m[2] ?? '';
                    if (preg_match('/^(https?:\/\/|mailto:|\/)/i', $href)) {
                        $safe = htmlspecialchars($href, ENT_QUOTES, 'UTF-8');
                        $relTarget = preg_match('/^https?:\/\//i', $href) ? ' target="_blank" rel="noopener noreferrer"' : '';
                        return '<a href="' . $safe . '"' . $relTarget . '>';
                    }
                    return '<a>';
                },
                $cleanDesc
            );
        }

        // Reject if sanitization removed all visible text
        if (trim(strip_tags($cleanDesc)) === '') {
            return back()->withErrors(['description' => 'Description kosong atau berisi HTML yang tidak diizinkan.'])->withInput();
        }

        $donation->update([
            'title' => $titleClean,
            'description' => $cleanDesc,
            'goal_amount' => $request->goal_amount,
        ]);

        return redirect()->route('donations.index')->with('success', 'Donation updated.');
    }
    
    public function destroy(Donation $donation)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        $donation->delete();

        return redirect()->route('donations.index')->with('success', 'Donation box deleted.');
    }
     
    private function checkAndAwardBadges(User $user)
    {
        // 1. Hitung total donasi (ambil nilai absolut dari jumlah negatif)
        $totalDonation = abs($user->transactions()->where('type', 'donation')->sum('amount'));

        // 2. Ambil ID badge yang sudah dimiliki user
        $currentBadgeIds = $user->badges()->pluck('badges.id');

        // 3. Cari badge baru yang layak didapat
        $newBadges = Badge::where('min_donation', '<=', $totalDonation) // Syarat donasi terpenuhi
                            ->whereNotIn('id', $currentBadgeIds)        // & Badge-nya belum dimiliki
                            ->get();

        // 4. Berikan badge baru ke user
        if ($newBadges->isNotEmpty()) {
            $user->badges()->attach($newBadges->pluck('id'));
            
            // Opsional: Beri notifikasi ke user bahwa mereka dapat badge baru
            // return redirect()->with('badge_success', 'Selamat! Anda mendapat badge baru!');
        }
    }
}
