@extends('partials.layouts.master')

@section('title', 'Dashboard | MyTripTaylor Admin')
@section('title-sub', 'Dashboard')
@section('pagetitle', 'Dashboard')

@section('content')

<!-- KPI Cards -->
<div class="row">
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div class="h-48px w-50px d-flex justify-content-center align-items-center text-primary fs-4 rounded-3 shadow-lg border">
                    <i class="ri-group-line"></i>
                </div>
                <div class="text-end">
                    <h3 class="mb-1">{{ number_format($totalUsers) }}</h3>
                    <span class="text-muted">Total Users</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div class="h-48px w-50px d-flex justify-content-center align-items-center text-success fs-4 rounded-3 shadow-lg border">
                    <i class="ri-flight-takeoff-line"></i>
                </div>
                <div class="text-end">
                    <h3 class="mb-1">{{ number_format($totalTrips) }}</h3>
                    <span class="text-muted">Total Trips</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div class="h-48px w-50px d-flex justify-content-center align-items-center text-warning fs-4 rounded-3 shadow-lg border">
                    <i class="ri-user-add-line"></i>
                </div>
                <div class="text-end">
                    <h3 class="mb-1">{{ $usersToday }}</h3>
                    <span class="text-muted">Users Today</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div class="h-48px w-50px d-flex justify-content-center align-items-center text-info fs-4 rounded-3 shadow-lg border">
                    <i class="ri-map-pin-add-line"></i>
                </div>
                <div class="text-end">
                    <h3 class="mb-1">{{ $tripsToday }}</h3>
                    <span class="text-muted">Trips Today</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Period Metrics -->
<div class="row">
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Users This Week</p>
                        <h4 class="mb-0">{{ $usersThisWeek }}</h4>
                    </div>
                    <span class="badge bg-primary-subtle text-primary fs-13 px-3 py-2">Week</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Trips This Week</p>
                        <h4 class="mb-0">{{ $tripsThisWeek }}</h4>
                    </div>
                    <span class="badge bg-success-subtle text-success fs-13 px-3 py-2">Week</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Users This Month</p>
                        <h4 class="mb-0">{{ $usersThisMonth }}</h4>
                    </div>
                    <span class="badge bg-primary-subtle text-primary fs-13 px-3 py-2">Month</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Trips This Month</p>
                        <h4 class="mb-0">{{ $tripsThisMonth }}</h4>
                    </div>
                    <span class="badge bg-success-subtle text-success fs-13 px-3 py-2">Month</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 1: Users & Trips over time -->
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Users & Trips (Last 30 Days)</h4>
            </div>
            <div class="card-body">
                <div id="users-trips-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Trips by Island</h4>
            </div>
            <div class="card-body">
                @if(count($islandCounts) > 0)
                <div id="trips-island-chart"></div>
                @else
                <div class="text-center text-muted py-5">No trip data yet</div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 2: Budget + Recent data -->
<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Trips by Budget</h4>
            </div>
            <div class="card-body">
                <div id="trips-budget-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Recent Users</h4>
                <a href="{{ route('admin.users.index') }}" class="link">View All</a>
            </div>
            <div class="card-body">
                @forelse($recentUsers as $user)
                <div class="d-flex align-items-center gap-3 {{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                    @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="avatar-sm rounded-pill">
                    @else
                    <div class="avatar-sm rounded-pill bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-semibold" style="min-width:32px;min-height:32px;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    @endif
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fs-13">{{ $user->name }}</h6>
                        <span class="text-muted fs-12">{{ $user->email }}</span>
                    </div>
                    <span class="text-muted fs-12">{{ $user->created_at->diffForHumans() }}</span>
                </div>
                @empty
                <div class="text-center text-muted py-3">No users yet</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Recent Trips</h4>
                <a href="{{ route('admin.trips.index') }}" class="link">View All</a>
            </div>
            <div class="card-body">
                @forelse($recentTrips as $trip)
                <div class="d-flex align-items-center gap-3 {{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                    <div class="h-40px w-40px d-flex justify-content-center align-items-center text-primary fs-5 rounded-3 bg-primary-subtle" style="min-width:40px;">
                        <i class="ri-map-pin-line"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fs-13">{{ $trip->island->name }}</h6>
                        <span class="text-muted fs-12">{{ $trip->user->name }} &middot; {{ $trip->duration_days }}d &middot; {{ $trip->num_adults }}A{{ $trip->num_children > 0 ? ' + ' . $trip->num_children . 'C' : '' }}</span>
                    </div>
                    <span class="text-muted fs-12">{{ $trip->created_at->diffForHumans() }}</span>
                </div>
                @empty
                <div class="text-center text-muted py-3">No trips yet</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Users & Trips line chart
    var lineOptions = {
        chart: {
            type: 'area',
            height: 350,
            toolbar: { show: false },
            fontFamily: 'inherit',
        },
        series: [
            { name: 'Users', data: @json($usersSeries) },
            { name: 'Trips', data: @json($tripsSeries) },
        ],
        colors: ['#3b82f6', '#10b981'],
        xaxis: {
            categories: @json($last30Days),
            labels: {
                rotate: -45,
                style: { fontSize: '11px' },
            },
            tickAmount: 10,
        },
        yaxis: {
            labels: { formatter: function(val) { return Math.floor(val); } },
            min: 0,
        },
        stroke: { curve: 'smooth', width: 2 },
        fill: {
            type: 'gradient',
            gradient: { opacityFrom: 0.4, opacityTo: 0.05 },
        },
        dataLabels: { enabled: false },
        tooltip: { shared: true, intersect: false },
        grid: { borderColor: '#f1f1f1' },
        legend: { position: 'top' },
    };
    new ApexCharts(document.querySelector('#users-trips-chart'), lineOptions).render();

    // Trips by island donut
    @if(count($islandCounts) > 0)
    var donutOptions = {
        chart: { type: 'donut', height: 350 },
        series: @json($islandCounts),
        labels: @json($islandLabels),
        colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316', '#6366f1'],
        legend: { position: 'bottom' },
        dataLabels: { enabled: true },
        plotOptions: {
            pie: {
                donut: { size: '55%' },
            },
        },
    };
    new ApexCharts(document.querySelector('#trips-island-chart'), donutOptions).render();
    @endif

    // Trips by budget bar
    var barOptions = {
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        series: [{ name: 'Trips', data: @json($budgetCounts) }],
        xaxis: { categories: @json($budgetLabels) },
        colors: ['#f59e0b'],
        plotOptions: {
            bar: { borderRadius: 6, columnWidth: '50%' },
        },
        dataLabels: { enabled: true },
        yaxis: {
            labels: { formatter: function(val) { return Math.floor(val); } },
            min: 0,
        },
        grid: { borderColor: '#f1f1f1' },
    };
    new ApexCharts(document.querySelector('#trips-budget-chart'), barOptions).render();
});
</script>
@endsection
