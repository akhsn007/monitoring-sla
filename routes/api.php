<?php

use App\Http\Controllers\LogEntryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::put('/log-entry/import-prtg', function (Request $request) {
    // Logic to import data from the PRTG JSON file
    // This should call the appropriate method in LogEntryController


    $jsonContent = $request->getContent();
    $data = json_decode($jsonContent, true);

    return $data;

    if (!is_array($data)) {
        return response()->json([
            'error' => 'Format file JSON tidak valid.'
        ], 400);
    }

    $timestamp = !empty($data['%lastcheck'])
        ? \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $data['%lastcheck'])->format('Y-m-d H:i:s')
        : now();

    $logEntry = \App\Models\LogEntry::create([
        'client_name' => $data['device'] ?? 'Tidak diketahui',
        'ip_address'  => $data['host'] ?? '0.0.0.0',
        'status'      => (stripos($data['laststatus'] ?? '', 'down') !== false || ($data['down'] ?? false)) ? 'down' : 'up',
        'root_cause'  => $data['history'] ?? ($data['group'] ?? 'Lainnya'),
        'timestamp'   => $timestamp,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Data PRTG berhasil diimpor.',
        'data' => $logEntry
    ]);
});
