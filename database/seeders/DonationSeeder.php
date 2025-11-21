<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonationSeeder extends Seeder
{
    public function run(): void
    {
        
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
                'title' => 'Renovasi Gereja Abraham',
                'slug' => 'renovasi-gereja-abraham',
                'description' => 'Shalom! Kami dari panitia pembangunan sedang melakukan penggalangan dana untuk renovasi gedung gereja.',
                'goal_amount' => 25000000,
                'collected_amount' => 0,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Renovasi Ruang Sekolah Minggu Pak Jeri',
                'slug' => 'renovasi-ruang-sekolah-minggu-pak-jeri',
                'description' => 'Salam sejahtera! Gereja kami saat ini sedang berupaya memperbaiki ruang sekolah minggu yang sudah tua.',
                'goal_amount' => 32000000,
                'collected_amount' => 0,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Penggalangan Dana Kebocoran Atap',
                'slug' => 'penggalangan-dana-kebocoran-atap',
                'description' => 'Shalom! Dalam beberapa bulan terakhir, gedung gereja kami mengalami banyak kebocoran ketika hujan.',
                'goal_amount' => 7000000,
                'collected_amount' => 0,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Perluasan Ruangan Gereja Pak Petrus',
                'slug' => 'perluasan-ruangan-gereja-pak-petrus',
                'description' => 'Salam damai sejahtera! Puji Tuhan, jemaat di gereja kami semakin bertambah setiap tahunnya. Namun diperlukan perluasan ruangan.',
                'goal_amount' => 75000000,
                'collected_amount' => 0,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        
        foreach ($items as $item) {
            $exists = DB::table('donations')->where('slug', $item['slug'])->exists();
            if ($exists) continue;
            DB::table('donations')->insert($item);
        }

        $this->command->info('Donation seed completed.');
    }
}
