<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEntry;
use Illuminate\Support\Facades\DB;

class ClientDataController extends Controller
{
    public function index()
{
    $total = LogEntry::count();
    
    $clients = LogEntry::select('client_name')
        ->where('status', 'down')
        ->selectRaw('COUNT(*) as total_down')
        ->selectRaw('ROUND((COUNT(*) / ?) * 100, 1) as percent', [$total ?: 1])
        ->selectRaw("'down' as status")
        ->groupBy('client_name')
        ->get();

    return view('client-data.index', compact('clients'));
}

}
