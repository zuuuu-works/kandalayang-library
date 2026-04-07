@extends('layouts.app')
@section('title', 'Librarian Dashboard')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
        <small class="text-muted">Welcome back, {{ auth()->user()->full_name }}!</small>
    </div>
    <a href="{{ route('e-resources.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Add E-Resource
    </a>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card blue p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Resources</div>
                    <div class="fs-4 fw-bold">{{ \App\Models\EResource::count() }}</div>
                </div>
                <i class="bi bi-journals fs-2 text-primary opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card green p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Users</div>
                    <div class="fs-4 fw-bold">{{ \App\Models\User::count() }}</div>
                </div>
                <i class="bi bi-people fs-2 text-success opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card orange p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Accesses</div>
                    <div class="fs-4 fw-bold">{{ \App\Models\AccessLog::count() }}</div>
                </div>
                <i class="bi bi-clock-history fs-2 text-warning opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card red p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Categories</div>
                    <div class="fs-4 fw-bold">{{ \App\Models\Category::count() }}</div>
                </div>
                <i class="bi bi-tag fs-2 text-danger opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Recent Access Logs --}}
    <div class="col-md-7">
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Access Logs</h6>
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Resource</th>
                            <th>Type</th>
                            <th>When</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\AccessLog::with(['user','eResource'])->latest('accessed_at')->take(8)->get() as $log)
                        <tr>
                            <td>{{ $log->user->full_name }}</td>
                            <td class="text-truncate" style="max-width:160px;">{{ $log->eResource->title }}</td>
                            <td>
                                <span class="badge bg-{{ $log->access_type === 'download' ? 'success' : ($log->access_type === 'stream' ? 'warning text-dark' : 'secondary') }}">
                                    {{ ucfirst($log->access_type) }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $log->accessed_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2 text-end">
                <a href="{{ route('reports.access-logs') }}" class="btn btn-sm btn-outline-primary">View All Logs</a>
            </div>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="col-md-5">
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-lightning me-2 text-warning"></i>Quick Actions</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('e-resources.create') }}" class="btn btn-outline-primary text-start">
                    <i class="bi bi-plus-circle me-2"></i>Add New E-Resource
                </a>
                <a href="{{ route('e-resources.index') }}" class="btn btn-outline-secondary text-start">
                    <i class="bi bi-journals me-2"></i>Manage E-Resources
                </a>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary text-start">
                    <i class="bi bi-people me-2"></i>Manage Users
                </a>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary text-start">
                    <i class="bi bi-bar-chart-line me-2"></i>View Reports
                </a>
                <a href="{{ route('search.index') }}" class="btn btn-outline-secondary text-start">
                    <i class="bi bi-search me-2"></i>Search Resources
                </a>
            </div>
        </div>
    </div>
</div>
@endsection