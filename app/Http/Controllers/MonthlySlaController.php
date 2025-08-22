<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEntry;
use Carbon\Carbon;

class MonthlySlaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan & tahun dari request, default: bulan sekarang
        $month = $request->input('month', Carbon::now()->month);
        $year  = $request->input('year', Carbon::now()->year);

        // Tentukan awal & akhir bulan
        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth   = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Ambil data log sesuai bulan & tahun
        $logs = LogEntry::whereBetween('timestamp', [$startOfMonth, $endOfMonth])->get();

        // Hitung SLA tiap klien
        $slaData = $logs->groupBy('client_name')->map(function ($items, $client) {
            $total = $items->count();
            $down  = $items->where('status', 'down')->count();
            $sla   = $total > 0 ? round(100 * ($total - $down) / $total, 2) : 100;

            return [
                'client_name' => $client,
                'total'       => $total,
                'down'        => $down,
                'sla'         => $sla,
            ];
        })->values();

        // Data untuk dropdown bulan & tahun
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $years = range(Carbon::now()->year - 2, Carbon::now()->year + 1); // bisa pilih -2 tahun sampai +1 tahun

        return view('monthly-sla.index', compact('slaData', 'months', 'years', 'month', 'year'));
    }
}
