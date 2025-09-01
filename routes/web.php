<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientDataController;
use App\Http\Controllers\MonthlySlaController;
use App\Http\Controllers\LogEntryController;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Illuminate\Support\Str;


// 👇 Arahkan root URL ke halaman dashboard (dengan pengecekan auth)
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 👇 Group semua route yang butuh login
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Log Entry (otomatis semua: index, create, store, edit, update, destroy)
    Route::resource('log-entry', LogEntryController::class);
    // Halaman lainnya
    Route::get('/client-data', [ClientDataController::class, 'index'])->name('client-data');
    Route::get('/monthly-sla', [MonthlySlaController::class, 'index'])->name('monthly-sla');

    // Profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('System/update', function () {
        return view('system.update');
    })->name('system.update');

    Route::get('/git-stash', fn() => runCommand([
        'git',
        '-c',
        'safe.directory=/var/www/monitoring-sla',
        'stash'
    ]))->name('git.stash');
    Route::get('/git-pull', fn() => runCommand([
        'git',
        '-c',
        'safe.directory=/var/www/monitoring-sla',
        'pull'
    ]))->name('git.pull');



    Route::get('/composer-install', function () {
        $process = new Process(['composer', 'install'], base_path());
        $process->run();

        // Strip ANSI escape codes for clean frontend display
        $cleanOutput = preg_replace('/\e

\[[\d;]*m/', '', $process->getOutput());
        $cleanError = preg_replace('/\e

\[[\d;]*m/', '', $process->getErrorOutput());

        return response()->json([
            'output' => $cleanOutput,
            'error' => $cleanError,
            'success' => $process->isSuccessful(),
        ]);
    })->name('composer.install');;

    Route::get('/migrate', function () {
        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();

            return response()->json(['output' => $output]);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    })->name('migrate');
    function runCommand(array $cmd)
    {
        try {
            $process = new \Symfony\Component\Process\Process($cmd);
            $process->run();
            if (!$process->isSuccessful()) throw new \Exception($process->getErrorOutput());
            return response()->json(['output' => $process->getOutput()]);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    Route::post('/log-entry/import-prtg', [LogEntryController::class, 'importFromPrtg'])
        ->name('log-entry.import-prtg');
    Route::post('log-entry/delete-all', [LogEntryController::class, 'deleteAll'])->name('log-entry.delete-all');
});
// 👇 Route auth bawaan Breeze
require __DIR__ . '/auth.php';
