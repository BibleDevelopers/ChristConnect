<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        
        
        $this->call([
            \Database\Seeders\GutenbergKJVSeeder::class,
            \Database\Seeders\KJVImportSeeder::class,
            
        ]);

        
        if (\DB::table('bible_verses')->count() === 0) {
            $this->call(\Database\Seeders\BibleDatabaseSeeder::class);
        }

        
        $this->call(\Database\Seeders\DonationSeeder::class);
    }
}
