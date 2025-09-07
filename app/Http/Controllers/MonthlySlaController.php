<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEntry;
use Carbon\Carbon;

class MonthlySlaController extends Controller
{
    public function index()
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        // filter log bulan ini
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth   = Carbon::create($year, $month, 1)->endOfMonth();

        $logs = LogEntry::whereBetween('timestamp', [$startOfMonth, $endOfMonth])->get();

        // 1️⃣ Pareto Root Cause
        $paretoRootCause = $logs->groupBy('client_name')->map(function ($items) {
            $rootCauseCounts = $items->groupBy('root_cause')->map->count();
            if ($rootCauseCounts->isEmpty()) {
                return ['root_cause' => '-', 'jumlah' => 0];
            }
            $top = $rootCauseCounts->sortDesc();

            return [
                'root_cause' => $top->keys()->first(),
                'jumlah'     => $top->first(),
            ];
        });

        // 2️⃣ Rekap SLA per PT
        $rekapSLA = $logs->groupBy('client_name')->map(function ($items) use ($month, $year) {
            $items = $items->sortByDesc("downtime");
            $total = $items->count();
            $down  = $items->where('status', 'like', 'Down')->count();
            $sla   = $total > 0 ? round(100 * ($total - $down) / $total, 2) : 100;
            $last_data = explode('%', $items->first->downtime);
            // dd($items->sortByDesc("downtime")->first());
            return [
                'bulan'       => Carbon::create()->month($month)->format('F'),
                'jumlah'      => $down,
                'total_menit' => explode("]", explode('[', $last_data[1])[1])[0], // contoh: 1 log down = 5 menit (bisa disesuaikan)
                'sla'         => number_format((float)$last_data[0], 2, '.', '')
            ];
        });

        // 3️⃣ Data Chart
        $labels = $rekapSLA->keys()->toArray();
        $values = $rekapSLA->pluck('sla')->toArray();

        // Nama bulan Indonesia
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return view('monthly-sla.index', compact(
            'paretoRootCause',
            'rekapSLA',
            'labels',
            'values',
            'months',
            'month',
            'year'
        ));
    }
}
