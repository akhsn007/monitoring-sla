<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEntry;
use Illuminate\Support\Facades\Http;

class LogEntryController extends Controller
{
    public function index()
    {
        $logs = LogEntry::latest()->get();
        return view('log-entry.index', compact('logs'));
    }

    public function create()
    {
        return view('log-entry.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string',
            'ip_address' => 'required|ip',
            'root_cause' => 'required',
            'status' => 'required|in:up,down'
        ]);

        LogEntry::create($request->all());
        return redirect()->route('log-entry.index')->with('success', 'Log berhasil ditambahkan');
    }

    public function edit(LogEntry $log_entry)
    {
        return view('log-entry.edit', compact('log_entry'));
    }

    public function update(Request $request, LogEntry $log_entry)
    {
        $request->validate([
            'client_name' => 'required|string',
            'ip_address' => 'required|ip',
            'root_cause' => 'required',
            'status' => 'required|in:up,down'
        ]);

        $log_entry->update($request->all());
        return redirect()->route('log-entry.index')->with('success', 'Log berhasil diperbarui');
    }

    public function destroy(LogEntry $log_entry)
    {
        $log_entry->delete();
        return redirect()->route('log-entry.index')->with('success', 'Log berhasil dihapus');
    }
    /**
     * Import data dari file JSON PRTG di storage/app/prtg/respon-prtg.json
     */
    public function importFromPrtg()
    {
        $jsonPath = storage_path('app/prtg/respon-prtg.json');

        if (!file_exists($jsonPath)) {
            return redirect()->route('log-entry.index')
                ->with('error', 'File respon-prtg.json tidak ditemukan di storage/app/prtg.');
        }

        $jsonContent = file_get_contents($jsonPath);
        $data = json_decode($jsonContent, true);

        if (!is_array($data)) {
            return redirect()->route('log-entry.index')
                ->with('error', 'Format file JSON tidak valid.');
        }

        // Konversi format tanggal PRTG (dd/mm/yyyy HH:ii:ss) ke MySQL
        $timestamp = null;
        if (!empty($data['datetime'])) {
            $timestamp = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $data['datetime'])->format('Y-m-d H:i:s');
        } else {
            $timestamp = now();
        }

        \App\Models\LogEntry::create([
            'client_name' => $data['device'] ?? 'Tidak diketahui',
            'ip_address'  => $data['host'] ?? '0.0.0.0',
            'status'      => (stripos($data['status'] ?? '', 'down') !== false) ? 'down' : 'up',
            'root_cause'  => $data['message'] ?? 'Lainnya', // ambil pesan lengkap
            'timestamp'   => $timestamp,
        ]);

        return redirect()->route('log-entry.index')->with('success', 'Data PRTG berhasil diimpor.');
    }

    public function deleteAll()
    {
    LogEntry::truncate();
    return redirect()->route('log-entry.index')->with('success', 'Semua log berhasil dihapus.');
    }
}
