<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BudgetLevel;
use App\Models\Island;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // KPI cards
        $totalUsers       = User::count();
        $totalTrips       = Trip::count();
        $usersToday       = User::whereDate('created_at', $now->toDateString())->count();
        $tripsToday       = Trip::whereDate('created_at', $now->toDateString())->count();
        $usersThisWeek    = User::where('created_at', '>=', $now->copy()->startOfWeek())->count();
        $tripsThisWeek    = Trip::where('created_at', '>=', $now->copy()->startOfWeek())->count();
        $usersThisMonth   = User::where('created_at', '>=', $now->copy()->startOfMonth())->count();
        $tripsThisMonth   = Trip::where('created_at', '>=', $now->copy()->startOfMonth())->count();

        // Users registered per day (last 30 days)
        $usersPerDay = User::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', $now->copy()->subDays(29)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Trips per day (last 30 days)
        $tripsPerDay = Trip::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', $now->copy()->subDays(29)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Fill missing days with 0
        $last30Days   = [];
        $usersSeries  = [];
        $tripsSeries  = [];
        for ($i = 29; $i >= 0; $i--) {
            $date          = $now->copy()->subDays($i)->toDateString();
            $last30Days[]  = Carbon::parse($date)->format('M d');
            $usersSeries[] = $usersPerDay[$date] ?? 0;
            $tripsSeries[] = $tripsPerDay[$date] ?? 0;
        }

        // Trips by island (for pie/donut chart)
        $tripsByIsland = Trip::select('island_id', DB::raw('COUNT(*) as count'))
            ->groupBy('island_id')
            ->pluck('count', 'island_id')
            ->toArray();

        $islands        = Island::pluck('name', 'id')->toArray();
        $islandLabels   = [];
        $islandCounts   = [];
        foreach ($tripsByIsland as $islandId => $count) {
            $islandLabels[] = $islands[$islandId] ?? 'Unknown';
            $islandCounts[] = $count;
        }

        // Trips by budget level (for bar chart)
        $tripsByBudget = Trip::select('budget_level_id', DB::raw('COUNT(*) as count'))
            ->groupBy('budget_level_id')
            ->pluck('count', 'budget_level_id')
            ->toArray();

        $budgetLevels  = BudgetLevel::orderBy('min_budget')->pluck('name', 'id')->toArray();
        $budgetLabels  = [];
        $budgetCounts  = [];
        foreach ($budgetLevels as $id => $name) {
            $budgetLabels[] = $name;
            $budgetCounts[] = $tripsByBudget[$id] ?? 0;
        }

        // Recent trips (last 5)
        $recentTrips = Trip::with(['user', 'island', 'city', 'budgetLevel'])
            ->latest()
            ->take(5)
            ->get();

        // Recent users (last 5)
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTrips',
            'usersToday',
            'tripsToday',
            'usersThisWeek',
            'tripsThisWeek',
            'usersThisMonth',
            'tripsThisMonth',
            'last30Days',
            'usersSeries',
            'tripsSeries',
            'islandLabels',
            'islandCounts',
            'budgetLabels',
            'budgetCounts',
            'recentTrips',
            'recentUsers',
        ));
    }
}
