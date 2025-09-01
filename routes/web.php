<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientDataController;
use App\Http\Controllers\MonthlySlaController;
use App\Http\Controllers\LogEntryController;
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


    Route::post('/git-stash', fn() => runCommand(['git', 'stash']))->name('git.stash');
    Route::post('/git-pull', fn() => runCommand(['git', 'pull']))->name('git.pull');
    Route::post('/composer-install', fn() => runCommand(['composer', 'install']))->name('composer.install');
    Route::post('/migrate', fn() => runCommand(['php', 'artisan', 'migrate', '--force']))->name('migrate');

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
