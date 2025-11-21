<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;

class CreateAdmin extends Command
{
    protected $signature = 'make:admin {--email=} {--password=} {--no-save}';
    protected $description = 'Create an admin user (secure).';

    public function handle()
    {
        $email = $this->option('email') ?? env('ADMIN_EMAIL');
        $password = $this->option('password') ?? env('ADMIN_PASSWORD');

        if (!$email) {
            $email = $this->ask('Admin email');
        }

        if (!$password) {
            $password = Str::random(24);
            $this->info('Generated a secure random password for the admin.');
        }

        $user = User::firstOrCreate([
            'email' => $email,
        ], [
            'name' => 'admin',
            'password' => Hash::make($password),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        if (!$user->wallet()->exists()) {
            $user->wallet()->create(['balance' => 0]);
        }

        $this->info("Admin user created/updated: {$user->email}");

        if (!$this->option('no-save')) {
            $fs = new Filesystem();
            $path = storage_path('app/admin-credentials.txt');
            $contents = "email={$email}\npassword={$password}\n";
            $fs->put($path, $contents);
            @chmod($path, 0600);
            $this->info('Credentials saved to: ' . $path);
            $this->warn('Please secure or remove this file after use.');
        } else {
            $this->info('Credentials not saved to disk (--no-save specified).');
        }

        return 0;
    }
}
