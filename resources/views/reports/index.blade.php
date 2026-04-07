@extends('layouts.app')

@section('title', 'Reports Overview')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-bar-chart-line me-2"></i>Reports Overview</h4>
    <small class="text-muted">System usage summary and analytics</small>
</div>

{{-- Summary Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card blue p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Users</div>
                    <div class="fs-3 fw-bold">{{ $totalUsers }}</div>
                </div>
                <i class="bi bi-people fs-2 text-primary opacity-50"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card green p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total E-Resources</div>
                    <div class="fs-3 fw-bold">{{ $totalResources }}</div>
                </div>
                <i class="bi bi-journals fs-2 text-success opacity-50"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card orange p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Accesses</div>
                    <div class="fs-3 fw-bold">{{ $totalAccesses }}</div>
                </div>
                <i class="bi bi-clock-history fs-2 text-warning opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- Top Resources --}}
    <div class="col-md-6">
        <div class="card p-3 h-100">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-trophy me-2 text-warning"></i>Most Accessed Resources
            </h6>

            @forelse($topResources as $resource)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span class="small text-truncate me-2" style="max-width:250px;">
                        {{ $resource->title }}
                    </span>
                    <span class="badge bg-primary rounded-pill">
                        {{ $resource->access_logs_count }}
                    </span>
                </div>
            @empty
                <p class="text-muted text-center py-3">No data yet.</p>
            @endforelse
        </div>
    </div>

    {{-- Top Users --}}
    <div class="col-md-6">
        <div class="card p-3 h-100">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-person-check me-2 text-success"></i>Most Active Users
            </h6>

            @forelse($topUsers as $user)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <span class="small fw-semibold">{{ $user->full_name }}</span>
                        <span class="badge ms-2 bg-light text-dark border" style="font-size:0.65rem;">
                            {{ $user->role }}
                        </span>
                    </div>
                    <span class="badge bg-success rounded-pill">
                        {{ $user->access_logs_count }}
                    </span>
                </div>
            @empty
                <p class="text-muted text-center py-3">No data yet.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Chart --}}
<div class="card p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-graph-up me-2 text-primary"></i>
            Daily Accesses (Last 30 Days)
        </h6>

        <a href="{{ route('reports.access-logs') }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-list-ul me-1"></i>View Detailed Logs
        </a>
    </div>

    {{-- Hidden Data --}}
    <div id="chart-labels"
         data-value='@json($dailyAccesses->pluck("date"))'
         style="display:none;"></div>

    <div id="chart-data"
         data-value='@json($dailyAccesses->pluck("count"))'
         style="display:none;"></div>

    <canvas id="dailyChart" height="80"></canvas>
</div>
@endsection


{{-- SCRIPTS --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const labels = JSON.parse(document.getElementById('chart-labels').dataset.value);
    const data   = JSON.parse(document.getElementById('chart-data').dataset.value);

    new Chart(document.getElementById('dailyChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Accesses',
                data: data,
                backgroundColor: 'rgba(13, 110, 253, 0.2)',
                borderColor: 'rgba(13, 110, 253, 0.8)',
                borderWidth: 2,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

});
</script>
@endpush