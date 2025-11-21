<?php


namespace App\Services; 

use App\Models\User;
use App\Models\Badge;
use Illuminate\Support\Facades\DB;
use Exception; 

class DonationService
{
    
    public function makeDonation(User $user, int $amount, string $description)
    {
        
        return DB::transaction(function () use ($user, $amount, $description) {
            
            
            $wallet = $user->wallet()->lockForUpdate()->first();

            
            if ($wallet->balance < $amount) {
                throw new Exception("Saldo tidak mencukupi untuk donasi.");
            }

            
            $wallet->decrement('balance', $amount);

            
            $user->transactions()->create([
                'type' => 'donation',
                'amount' => -$amount, 
                'description' => $description,
                'user_id' => $user->id 
            ]);

            
            $this->checkAndAwardBadges($user);

            return true;
        });
    }

    
    public function checkAndAwardBadges(User $user)
    {
        
        $totalDonation = abs($user->transactions()->where('type', 'donation')->sum('amount'));

        
        $currentBadgeIds = $user->badges()->pluck('badges.id');

        
        $newBadges = Badge::where('min_donation', '<=', $totalDonation) 
                            ->whereNotIn('id', $currentBadgeIds) 
                            ->get();

        
        if ($newBadges->isNotEmpty()) {
            $user->badges()->attach($newBadges->pluck('id'));
        }
    }
}