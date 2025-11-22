<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Donation;

use App\Models\User;
use App\Models\Badge;
use App\Models\Transaction;

class DonationController extends Controller
{
    private BadgeService $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    public function index()
    {
        // If not logged in → redirect to login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

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
        // Only admins may create donation boxes
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal_amount' => 'required|numeric|min:1',
        ]);

        $donation = Donation::create([
            'title' => $request->title,
            'description' => $request->description,
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
        // Admin only
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

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
        $request->validate([
            'amount' => 'required|integer|min:1000|max:1000000000',
        ]);

        // Ensure authenticated (defensive)
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $amount = (int) $request->input('amount');
        if ($amount <= 0) {
            return back()->with('error', 'Jumlah donasi tidak valid.');
        }

        try {
            DB::transaction(function () use ($user, $amount, $donation) {
                
                // 1. Ambil wallet user & KUNCI (agar aman dari double-spending)
                $wallet = $user->wallet()->lockForUpdate()->first();

                // Defensive: ensure wallet exists
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
            // Jika saldo tidak cukup atau ada error
            // Redirect kembali ke halaman donasi dengan pesan error
            return redirect()->back()->with('error', $e->getMessage());
        }

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

        $donation->update([
            'title' => $request->title,
            'description' => $request->description,
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
