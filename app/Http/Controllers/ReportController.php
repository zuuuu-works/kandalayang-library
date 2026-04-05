<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use App\Models\EResource;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show the main reports dashboard. (Librarian only)
     */
    public function index()
    {
        // Summary stats
        $totalUsers      = User::count();
        $totalResources  = EResource::count();
        $totalAccesses   = AccessLog::count();

        // Most accessed resources (top 10)
        $topResources = EResource::withCount('accessLogs')
            ->orderByDesc('access_logs_count')
            ->take(10)
            ->get();

        // Most active users (top 10)
        $topUsers = User::withCount('accessLogs')
            ->orderByDesc('access_logs_count')
            ->take(10)
            ->get();

        // Accesses per day (last 30 days)
        $dailyAccesses = AccessLog::selectRaw('DATE(accessed_at) as date, COUNT(*) as count')
            ->where('accessed_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('reports.index', compact(
            'totalUsers',
            'totalResources',
            'totalAccesses',
            'topResources',
            'topUsers',
            'dailyAccesses'
        ));
    }

    /**
     * Show access logs with filters. (Librarian only)
     */
    public function accessLogs(Request $request)
    {
        $query = AccessLog::with(['user', 'eResource'])->latest('accessed_at');

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by e-resource
        if ($request->filled('e_resource_id')) {
            $query->where('e_resource_id', $request->e_resource_id);
        }

        // Filter by access type
        if ($request->filled('access_type')) {
            $query->where('access_type', $request->access_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('accessed_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('accessed_at', '<=', $request->date_to);
        }

        $logs       = $query->paginate(20)->withQueryString();
        $users      = User::all();
        $eResources = EResource::all();

        return view('reports.access-logs', compact('logs', 'users', 'eResources'));
    }
}
