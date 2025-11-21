<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonationSeeder extends Seeder
{
    public function run(): void
    {
        // If a donations table doesn't exist, skip gracefully
        try {
            if (!\Schema::hasTable('donations')) {
                $this->command->info('Skipping donations seeder: table `donations` not found.');
                return;
            }
        } catch (\Exception $e) {
            $this->command->error('Error checking donations table: ' . $e->getMessage());
            return;
        }

        $now = now();

        $items = [
            [
                'title' => 'General Fund',
                'slug' => 'general-fund',
                'description' => 'Support our community programs and operations.',
                'goal_amount' => 5000000, // in cents or smallest currency unit
                'collected_amount' => 1250000,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Building Fund',
                'slug' => 'building-fund',
                'description' => 'Help finance the construction of our new meeting hall.',
                'goal_amount' => 20000000,
                'collected_amount' => 4000000,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Mission Support',
                'slug' => 'mission-support',
                'description' => 'Support our mission and outreach partners.',
                'goal_amount' => 10000000,
                'collected_amount' => 2500000,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Avoid duplicate slugs: insert only those that don't exist
        foreach ($items as $item) {
            $exists = DB::table('donations')->where('slug', $item['slug'])->exists();
            if ($exists) continue;
            DB::table('donations')->insert($item);
        }

        $this->command->info('Donation seed completed.');
    }
}
