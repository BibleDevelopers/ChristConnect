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

        // Use the four donation campaigns shown in the donations view (Indonesian titles)
        $items = [
            [
                'title' => 'Renovasi Gereja Abraham',
                'description' => 'Shalom! Kami dari panitia pembangunan sedang melakukan penggalangan dana untuk renovasi gedung gereja.',
                'goal_amount' => 25000000,
                'collected_amount' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Renovasi Ruang Sekolah Minggu Pak Jeri',
                'description' => 'Salam sejahtera! Gereja kami saat ini sedang berupaya memperbaiki ruang sekolah minggu yang sudah tua.',
                'goal_amount' => 32000000,
                'collected_amount' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Penggalangan Dana Kebocoran Atap',
                'description' => 'Shalom! Dalam beberapa bulan terakhir, gedung gereja kami mengalami banyak kebocoran ketika hujan.',
                'goal_amount' => 7000000,
                'collected_amount' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Perluasan Ruangan Gereja Pak Petrus',
                'description' => 'Salam damai sejahtera! Puji Tuhan, jemaat di gereja kami semakin bertambah setiap tahunnya. Namun diperlukan perluasan ruangan.',
                'goal_amount' => 75000000,
                'collected_amount' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Avoid duplicate titles: insert only those that don't exist
        foreach ($items as $item) {
            // avoid relying on slug; deduplicate by title instead
            $exists = DB::table('donations')->where('title', $item['title'])->exists();
            if ($exists) continue;
            DB::table('donations')->insert($item);
        }

        $this->command->info('Donation seed completed.');
    }
}
