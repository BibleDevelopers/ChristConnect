<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RemoveTBSeeder extends Seeder
{
    public function run(): void
    {
        $before = DB::table('bible_verses')->where('version', 'tb')->count();
        $this->command->info("Found {$before} TB rows. Deleting...");

        $deleted = DB::table('bible_verses')->where('version', 'tb')->delete();

        $after = DB::table('bible_verses')->where('version', 'tb')->count();
        $this->command->info("Deleted: {$deleted} rows. Remaining TB rows: {$after}");
    }
}
