<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\BadgeService;

class SyncUserBadges extends Command
{
    protected $signature = 'badges:sync';
    protected $description = 'Sync all user badges based on their total donations';

    public function handle(BadgeService $badgeService)
    {
        $users = User::where('total_donated', '>', 0)->get();

        foreach ($users as $user) {
            $badgeService->syncDonationBadges($user);
        }

        $this->info('All user badges synced successfully!');
    }
}
