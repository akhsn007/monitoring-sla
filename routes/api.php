<?php

use App\Http\Controllers\LogEntryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::put('/log-entry/import-prtg', function (Request $request) {
    // Logic to import data from the PRTG JSON file
    // This should call the appropriate method in LogEntryController


    $jsonContent = $request->getContent();
    $data = json_decode($jsonContent, true);

    $timestamp = !empty($data['%lastcheck'])
        ? \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $data['%lastcheck'])->format('Y-m-d H:i:s')
        : now();
    // return response()->json([
    //     'success' => false,
    //     'message' => 'Data PRTG gagal diimpor.',
    //     'data' => $data
    // ], 200);

    Log::info('Received PRTG data:', $data);

    $logEntry = \App\Models\LogEntry::updateOrCreate([
        'ip_address'  => $data['host'] ?? '0.0.0.0',
        'lastdown'    => $data['lastdown'] ?? null,
    ], [
        'client_name' => $data['device'] ?? 'Tidak diketahui',
        'ip_address'  => $data['host'] ?? '0.0.0.0',
        'status'      => $data['laststatus'] ?? 'Unknown',
        'root_cause'  => $data['history'] ?? ($data['group'] ?? 'Lainnya'),
        'lastdown'    => $data['lastdown'] ?? null,
        'deviceid'    => $data['deviceid'] ?? null,
        'downtime'    => $data['downtime'] ?? null,
        'timestamp'   => $timestamp,
    ]);
    // Log::info('log enttri:', $logEntry->toArray());

    return response()->json([
        'success' => true,
        'message' => 'Data PRTG berhasil diimpor.',
        'data' => $logEntry
    ]);
});
