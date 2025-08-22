<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEntry;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLogs = LogEntry::count();
        $totalDown = LogEntry::where('status', 'down')->count();
        $totalClients = LogEntry::distinct('client_name')->count('client_name');
        $avgSla = 100 - ($totalDown / max($totalLogs, 1)) * 100;

        // Pie chart: root cause
        $rootCauseLabels = LogEntry::select('root_cause')->distinct()->pluck('root_cause');
        $rootCauseCounts = LogEntry::selectRaw('root_cause, COUNT(*) as total')
            ->groupBy('root_cause')
            ->pluck('total');

        // Bar chart: jumlah tiket per klien
        $siteLabels = LogEntry::select('client_name')->distinct()->pluck('client_name');
        $siteCounts = LogEntry::selectRaw('client_name, COUNT(*) as total')
            ->groupBy('client_name')
            ->pluck('total');

        return view('dashboard', [
            'totalLogs' => $totalLogs,
            'totalClients' => $totalClients,
            'monitoredDevices' => $totalLogs, // bisa diubah jika ada data perangkat
            'downCount' => $totalDown,
            'avgSla' => number_format($avgSla, 1),
            'rootCauseLabels' => $rootCauseLabels,
            'rootCauseCounts' => $rootCauseCounts,
            'siteLabels' => $siteLabels,
            'siteCounts' => $siteCounts,
        ]);
    }
}
