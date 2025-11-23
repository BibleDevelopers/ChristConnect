<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ensure users table exists
        if (! Schema::hasTable('users')) {
            $this->command->info('Skipping UserSeeder: table `users` not found.');
            return;
        }

        $email = 'admin@christ.connect';
        $passwordPlain = env('ADMIN_PASSWORD');

        // find existing user or create new instance
        $user = User::where('email', $email)->first();
        if (! $user) {
            $user = new User();
            $user->email = $email;
        }

        // assign/ensure properties (use direct assignment to avoid mass-assignment issues)
        $user->name = 'admin';
        $user->password = Hash::make($passwordPlain);
        $user->email_verified_at = now();
        $user->remember_token = Str::random(60);

        // only set role/total_donated if columns exist to avoid migration errors
        if (Schema::hasColumn('users', 'role')) {
            $user->role = 'admin';
        }
        if (Schema::hasColumn('users', 'total_donated')) {
            // ensure integer default
            $user->total_donated = $user->total_donated ?? 0;
        }

        $user->save();

        $this->command->info("Admin user created/updated: {$email} (password set as requested).");
        $this->command->warn('For production, rotate this password and secure the account immediately.');
    }
}
