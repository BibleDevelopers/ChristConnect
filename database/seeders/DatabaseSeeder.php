<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Try to import Gutenberg/KJV/TB. Only seed the small sample if the table
        // remains empty after the importers (acts as a last-resort fallback).
        $this->call([
            \Database\Seeders\GutenbergKJVSeeder::class,
            \Database\Seeders\KJVImportSeeder::class,
            \Database\Seeders\TBImportSeeder::class,
        ]);

        // If imports did not populate the `bible_verses` table, seed the small sample.
        if (\DB::table('bible_verses')->count() === 0) {
            $this->call(\Database\Seeders\BibleDatabaseSeeder::class);
        }
    }
}
