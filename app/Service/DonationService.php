<?php

// Pastikan namespace-nya benar sesuai lokasi file
namespace App\Services; 

use App\Models\User;
use App\Models\Badge;
use Illuminate\Support\Facades\DB;
use Exception; // Ganti Throwable menjadi Exception standar agar lebih mudah

class DonationService
{
    /**
     * Proses donasi dari user
     */
    public function makeDonation(User $user, int $amount, string $description)
    {
        // Gunakan DB Transaction agar aman. Jika satu gagal, semua batal.
        return DB::transaction(function () use ($user, $amount, $description) {
            
            // 1. KUNCI dompet user agar tidak ada proses lain
            $wallet = $user->wallet()->lockForUpdate()->first();

            // 2. Cek saldo
            if ($wallet->balance < $amount) {
                throw new Exception("Saldo tidak mencukupi untuk donasi.");
            }

            // 3. Kurangi saldo
            $wallet->decrement('balance', $amount);

            // 4. Catat transaksi donasi (perhatikan: amount negatif)
            $user->transactions()->create([
                'type' => 'donation',
                'amount' => -$amount, // Negatif karena uang keluar
                'description' => $description,
                'user_id' => $user->id // Pastikan user_id juga diisi
            ]);

            // 5. Cek & berikan badge baru jika perlu
            $this->checkAndAwardBadges($user);

            return true;
        });
    }

    /**
     * Cek total donasi dan berikan badge
     */
    public function checkAndAwardBadges(User $user)
    {
        // 1. Hitung total donasi (ambil nilai absolut)
        $totalDonation = abs($user->transactions()->where('type', 'donation')->sum('amount'));

        // 2. Ambil ID badge yang sudah dimiliki user
        $currentBadgeIds = $user->badges()->pluck('badges.id');

        // 3. Cari badge baru yang layak didapat
        $newBadges = Badge::where('min_donation', '<=', $totalDonation) // Syarat terpenuhi
                            ->whereNotIn('id', $currentBadgeIds) // Yang belum dimiliki
                            ->get();

        // 4. Berikan badge baru ke user
        if ($newBadges->isNotEmpty()) {
            $user->badges()->attach($newBadges->pluck('id'));
        }
    }
}