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
        $avgSla = ($totalDown / $totalLogs) * 100;

        // Pie chart: root cause
        $rootCauseLabels = LogEntry::select('root_cause')->distinct()->pluck('root_cause');
        $rootCauseCounts = LogEntry::selectRaw('root_cause, COUNT(*) as total')
            ->groupBy('root_cause')
            ->pluck('total');
        // Bar chart: jumlah tiket per klien
        $siteData = LogEntry::selectRaw('client_name, COUNT(*) as total')
            ->groupBy('client_name')
            ->orderBy('client_name') // opsional, untuk urutan konsisten
            ->get();

        $siteLabels = $siteData->pluck('client_name');
        $siteCounts = $siteData->pluck('total');

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
