<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');


Artisan::command('install:app', function () {
    // 1. Check install mode in .env
    if (env('INSTALL_MODE', true) == false) {
        $this->error('Application is already installed.');
        return;
    }

    // 2. Fresh database
    $this->info('Refreshing database...');
    Artisan::call('migrate:fresh --force');
    $this->info('Database refreshed.');

    // 3. Make user to login (input email and password)
    $email = $this->ask('Enter admin email');
    $password = $this->secret('Enter admin password');

    // Create user (assuming User model exists)
    $userModel = config('auth.providers.users.model', \App\Models\User::class);
    $userModel::create([
        'name' => 'Admin',
        'email' => $email,
        'password' => bcrypt($password),
    ]);
    $this->info('Admin user created.');

    // 4. Change INSTALL_MODE in .env to false
    $envPath = base_path('.env');
    $envContent = file_get_contents($envPath);
    $envContent = preg_replace('/^INSTALL_MODE=.*/m', 'INSTALL_MODE=false', $envContent);
    file_put_contents($envPath, $envContent);

    $this->info('Installation complete. INSTALL_MODE set to false.');
})->purpose('Install the application');
