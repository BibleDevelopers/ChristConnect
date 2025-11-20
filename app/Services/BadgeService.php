<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;

class BadgeService
{
    private const BADGES = [
        [
            'name' => 'Bronze Donor',
            'min' => 1,
            'icon' => null,
        ],
        [
            'name' => 'Silver Donor',
            'min' => 1_000_000,
            'icon' => null,
        ],
        [
            'name' => 'Gold Donor',
            'min' => 50_000_000,
            'icon' => null,
        ],
        [
            'name' => 'Platinum Donor',
            'min' => 100_000_000,
            'icon' => null,
        ],
    ];

    public function syncDonationBadges(User $user): void
    {
        $total = $user->total_donated ?? 0;

        // Temukan badge tertinggi yang user qualify
        $highestBadge = null;
        foreach (self::BADGES as $data) {
            $badge = Badge::firstOrCreate(
                ['name' => $data['name']],
                ['min_donation' => $data['min'], 'icon_url' => $data['icon']]
            );

            if ($total >= $badge->min_donation) {
                $highestBadge = $badge;
            }
        }

        // Lepas semua badge donor lama
        $user->badges()->detach(
            Badge::whereIn('name', [
                'Bronze Donor',
                'Silver Donor',
                'Gold Donor',
                'Platinum Donor',
            ])->pluck('id')
        );

        // Attach hanya badge tertinggi
        if ($highestBadge) {
            $user->badges()->attach($highestBadge->id);
        }
    }
}
