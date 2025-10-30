<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Donation;
use App\Models\DonationOption;

use App\Models\User;
use App\Models\Badge;
use App\Models\Transaction;

class DonationController extends Controller
{
    public function index()
    {
        // If not logged in → redirect to login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $donations = Donation::with('options')->get();
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
            'options' => 'nullable|string', // newline-separated label|amount or amount
        ]);

        DB::transaction(function () use ($request, &$donation) {
            $donation = Donation::create([
                'title' => $request->title,
                'description' => $request->description,
                'goal_amount' => $request->goal_amount,
                'collected_amount' => 0,
            ]);

            // parse options textarea (admin convenience)
            $optionsInput = $request->input('options', '');
            if (!empty($optionsInput)) {
                $lines = preg_split('/\r\n|\r|\n/', $optionsInput);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '') continue;

                    if (strpos($line, '|') !== false) {
                        [$label, $amount] = array_map('trim', explode('|', $line, 2));
                    } else {
                        $label = null;
                        $amount = $line;
                    }

                    $amount = preg_replace('/[^0-9.]/', '', $amount);
                    if ($amount === '') continue;

                    DonationOption::create([
                        'donation_id' => $donation->id,
                        'label' => $label,
                        'amount' => $amount,
                    ]);
                }
            }
        });

        return redirect()->route('donations.index')->with('success', 'Donation box created!');
    }

    public function edit(Donation $donation)
    {
        // Admin only
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('donations.index')->with('error', 'Unauthorized');
        }

        $donation->load('options');
        return view('donations.edit', compact('donation'));
    }


    public function donate(Request $request, Donation $donation)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000', // Misal, min donasi 1000
        ]);

        $user   = Auth::user();
        $amount = (int) $request->amount;

        try {
            // MULAI TRANSAKSI DATABASE (PENTING!)
            // Ini memastikan jika ada 1 gagal, semua dibatalkan
            DB::transaction(function () use ($user, $amount, $donation) {
                
                // 1. Ambil wallet user & KUNCI (agar aman dari double-spending)
                $wallet = $user->wallet()->lockForUpdate()->first();

                // 2. Cek Saldo
                if ($wallet->balance < $amount) {
                    // Melempar error ini akan otomatis membatalkan transaksi (rollback)
                    throw new \Exception('Saldo dompet Anda tidak mencukupi.');
                }

                // 3. Kurangi Saldo Wallet
                $wallet->decrement('balance', $amount);

                // 4. Catat di Transactions
                $user->transactions()->create([
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

        // 6. Cek & Beri Badge (Setelah transaksi berhasil)
        $this->checkAndAwardBadges($user);

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
            'options' => 'nullable|array',
            'options.*.id' => 'nullable|integer|exists:donation_options,id',
            'options.*.label' => 'nullable|string|max:255',
            'options.*.amount' => 'required_with:options.*|numeric|min:0.01',
            'options.*._delete' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request, $donation) {
            $donation->update([
                'title' => $request->title,
                'description' => $request->description,
                'goal_amount' => $request->goal_amount,
            ]);

            $options = $request->input('options', []);
            foreach ($options as $opt) {
                // delete existing
                if (!empty($opt['_delete']) && !empty($opt['id'])) {
                    DonationOption::where('id', $opt['id'])->where('donation_id', $donation->id)->delete();
                    continue;
                }

                // update existing
                if (!empty($opt['id'])) {
                    DonationOption::where('id', $opt['id'])->where('donation_id', $donation->id)
                        ->update([
                            'label' => $opt['label'] ?? null,
                            'amount' => $opt['amount'],
                        ]);
                    continue;
                }

                // create new
                if (empty($opt['_delete'])) {
                    if (!empty($opt['amount'])) {
                        DonationOption::create([
                            'donation_id' => $donation->id,
                            'label' => $opt['label'] ?? null,
                            'amount' => $opt['amount'],
                        ]);
                    }
                }
            }
        });

        return redirect()->route('donations.index')->with('success', 'Donation updated.');
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
