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

@php
    $pendingRequests        = \App\Models\ResourceRequest::where('status', 'pending')->count();
    $pendingRecommendations = \App\Models\Recommendation::where('status', 'pending')->count();
@endphp

{{-- ── Stat Cards ──────────────────────────────────────────── --}}
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
        <a href="{{ route('resource-requests.admin') }}" class="text-decoration-none">
            <div class="card stat-card p-3 {{ $pendingRequests > 0 ? 'border-danger border-2' : '' }}"
                 style="background: {{ $pendingRequests > 0 ? '#fff5f5' : 'white' }}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Pending Requests</div>
                        <div class="fs-4 fw-bold {{ $pendingRequests > 0 ? 'text-danger' : '' }}">
                            {{ $pendingRequests }}
                        </div>
                    </div>
                    <div class="position-relative">
                        <i class="bi bi-envelope-plus fs-2 text-danger opacity-50"></i>
                        @if($pendingRequests > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                  style="font-size:0.6rem;">!</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

{{-- ── Row 1: Access Logs + Quick Actions ─────────────────── --}}
<div class="row g-3 mb-3">

    {{-- Recent Access Logs --}}
    <div class="col-md-7">
        <div class="card p-3">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-clock-history me-2 text-primary"></i>Recent Access Logs
            </h6>
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
                            <td class="small">{{ $log->user->full_name }}</td>
                            <td class="text-truncate small" style="max-width:160px;">{{ $log->eResource->title }}</td>
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

    {{-- Quick Actions --}}
    <div class="col-md-5">
        <div class="card p-3">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-lightning me-2 text-warning"></i>Quick Actions
            </h6>
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
                <a href="{{ route('recommendations.admin') }}" class="btn text-start
                    {{ $pendingRecommendations > 0 ? 'btn-warning' : 'btn-outline-warning' }}">
                    <i class="bi bi-star me-2"></i>Recommendations
                    @if($pendingRecommendations > 0)
                        <span class="badge bg-dark ms-1">{{ $pendingRecommendations }} pending</span>
                    @endif
                </a>
                <a href="{{ route('resource-requests.admin') }}" class="btn text-start
                    {{ $pendingRequests > 0 ? 'btn-danger' : 'btn-outline-danger' }}">
                    <i class="bi bi-envelope-plus me-2"></i>Resource Requests
                    @if($pendingRequests > 0)
                        <span class="badge bg-white text-danger ms-1">{{ $pendingRequests }} pending</span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── Row 2: Faculty Recommendations + Resource Requests ──── --}}
<div class="row g-3">

    {{-- Faculty Recommendations --}}
    <div class="col-md-6">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-star me-2 text-warning"></i>Faculty Recommendations
                    @if($pendingRecommendations > 0)
                        <span class="badge bg-warning text-dark ms-1">{{ $pendingRecommendations }} pending</span>
                    @endif
                </h6>
                <a href="{{ route('recommendations.admin') }}" class="btn btn-sm btn-outline-secondary">
                    View All
                </a>
            </div>

            @php $recentRecs = \App\Models\Recommendation::with('user')->latest()->take(5)->get(); @endphp

            @if($recentRecs->isEmpty())
                <div class="text-center py-3 text-muted small">
                    <i class="bi bi-star fs-3 d-block mb-2 opacity-50"></i>
                    No recommendations yet.
                </div>
            @else
                @foreach($recentRecs as $rec)
                <div class="d-flex justify-content-between align-items-start py-2 border-bottom">
                    <div style="max-width:220px;">
                        <div class="small fw-semibold text-truncate">{{ $rec->title }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">
                            by {{ $rec->author_name }}
                            &nbsp;·&nbsp;
                            <span class="fw-semibold">{{ $rec->user->full_name }}</span>
                        </div>
                        @if($rec->reason)
                            <div class="text-muted fst-italic" style="font-size:0.72rem;">
                                "{{ Str::limit($rec->reason, 50) }}"
                            </div>
                        @endif
                    </div>
                    <div class="d-flex flex-column align-items-end gap-1">
                        <span class="badge bg-{{ $rec->status === 'approved' ? 'success' : ($rec->status === 'rejected' ? 'danger' : 'warning text-dark') }}">
                            {{ ucfirst($rec->status) }}
                        </span>
                        @if($rec->status === 'pending')
                        <div class="d-flex gap-1">
                            <form method="POST" action="{{ route('recommendations.status', $rec) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button class="btn btn-outline-success btn-sm" style="padding:1px 6px; font-size:0.72rem;" title="Approve">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('recommendations.status', $rec) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button class="btn btn-outline-danger btn-sm" style="padding:1px 6px; font-size:0.72rem;" title="Reject">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- Resource Requests --}}
    <div class="col-md-6">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-envelope-plus me-2 text-danger"></i>Resource Requests
                    @if($pendingRequests > 0)
                        <span class="badge bg-danger ms-1">{{ $pendingRequests }} pending</span>
                    @endif
                </h6>
                <a href="{{ route('resource-requests.admin') }}" class="btn btn-sm btn-outline-secondary">
                    View All
                </a>
            </div>

            @php $recentRequests = \App\Models\ResourceRequest::with('user')->latest()->take(5)->get(); @endphp

            @if($recentRequests->isEmpty())
                <div class="text-center py-3 text-muted small">
                    <i class="bi bi-inbox fs-3 d-block mb-2 opacity-50"></i>
                    No resource requests yet.
                </div>
            @else
                @foreach($recentRequests as $req)
                <div class="d-flex justify-content-between align-items-start py-2 border-bottom">
                    <div style="max-width:210px;">
                        <div class="small fw-semibold text-truncate">{{ $req->title }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">
                            <span class="fw-semibold">{{ $req->user->full_name }}</span>
                            &nbsp;·&nbsp;{{ $req->created_at->format('M d, Y') }}
                        </div>
                        @if($req->purpose)
                            <div class="text-muted fst-italic" style="font-size:0.72rem;">
                                "{{ Str::limit($req->purpose, 50) }}"
                            </div>
                        @endif
                    </div>
                    <div class="d-flex flex-column align-items-end gap-1">
                        <span class="badge bg-{{ $req->urgency === 'high' ? 'danger' : ($req->urgency === 'medium' ? 'warning text-dark' : 'secondary') }}">
                            {{ ucfirst($req->urgency) }}
                        </span>
                        <span class="badge bg-{{ $req->status === 'fulfilled' ? 'success' : ($req->status === 'declined' ? 'danger' : ($req->status === 'processing' ? 'info text-dark' : 'warning text-dark')) }}">
                            {{ ucfirst($req->status) }}
                        </span>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

</div>
@endsection