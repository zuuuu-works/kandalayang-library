@extends('layouts.app')
@section('title', 'Faculty Dashboard')

@section('content')

@php
    $user            = auth()->user();
    $myLogs          = $user->accessLogs()->with('eResource')->latest('accessed_at')->take(6)->get();
    $recommendations = \App\Models\Recommendation::where('user_id', $user->id)->latest()->get();
@endphp

{{-- ── Welcome Header ─────────────────────────────────────── --}}
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-person-workspace me-2"></i>Dashboard</h4>
        <small class="text-muted">Welcome back, {{ $user->full_name }}! Here's your overview.</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('recommendations.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-stars me-1"></i> Recommend a Resource
        </a>
        <a href="{{ route('search.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-search me-1"></i> Browse
        </a>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ── Stat Cards ──────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card blue p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Available Resources</div>
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
                    <div class="text-muted small">My Total Accesses</div>
                    <div class="fs-4 fw-bold">{{ $user->accessLogs()->count() }}</div>
                </div>
                <i class="bi bi-clock-history fs-2 text-success opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card orange p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Categories</div>
                    <div class="fs-4 fw-bold">{{ \App\Models\Category::count() }}</div>
                </div>
                <i class="bi bi-tag fs-2 text-warning opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card red p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">My Recommendations</div>
                    <div class="fs-4 fw-bold">{{ $recommendations->count() }}</div>
                </div>
                <i class="bi bi-stars fs-2 text-danger opacity-50"></i>
            </div>
        </div>
    </div>
</div>

{{-- ── Row 1: Recent Accesses + Quick Actions ──────────────── --}}
<div class="row g-3 mb-3">

    {{-- Recently Accessed --}}
    <div class="col-md-7">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-clock-history me-2 text-primary"></i>My Recent Accesses
                </h6>
                <a href="{{ route('history.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            @if($myLogs->isEmpty())
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-3 d-block mb-2 opacity-50"></i>
                    <p class="small mb-0">You haven't accessed any resources yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr><th>Resource</th><th>Type</th><th>When</th></tr>
                        </thead>
                        <tbody>
                            @foreach($myLogs as $log)
                            <tr>
                                <td class="text-truncate small" style="max-width:200px;">
                                    {{ $log->eResource->title }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $log->access_type === 'download' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($log->access_type) }}
                                    </span>
                                </td>
                                <td class="text-muted small">{{ $log->accessed_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="col-md-5">
        <div class="card p-3 h-100">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-lightning me-2 text-warning"></i>Quick Actions
            </h6>
            <div class="d-grid gap-2">
                <a href="{{ route('search.index') }}" class="btn btn-primary text-start btn-sm">
                    <i class="bi bi-search me-2"></i>Browse & Search Resources
                </a>
                <a href="{{ route('bookmarks.index') }}" class="btn btn-outline-warning text-start btn-sm">
                    <i class="bi bi-bookmark-heart me-2"></i>My Bookmarks
                </a>
                <a href="{{ route('history.index') }}" class="btn btn-outline-secondary text-start btn-sm">
                    <i class="bi bi-clock-history me-2"></i>Reading History
                </a>
                <a href="{{ route('search.index') }}?file_type=PDF" class="btn btn-outline-secondary text-start btn-sm">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Browse PDFs
                </a>
                <a href="{{ route('search.index') }}?file_type=ePub" class="btn btn-outline-secondary text-start btn-sm">
                    <i class="bi bi-book me-2"></i>Browse ePubs
                </a>
                <a href="{{ route('recommendations.create') }}" class="btn btn-outline-danger text-start btn-sm">
                    <i class="bi bi-stars me-2"></i>Recommend a Resource
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── Row 2: My Recommendations ───────────────────────────── --}}
<div class="row g-3">
    <div class="col-12">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-stars me-2 text-danger"></i>My Recommendations
                </h6>
                <a href="{{ route('recommendations.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> New Recommendation
                </a>
            </div>

            @if($recommendations->isEmpty())
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-3 d-block mb-2 opacity-50"></i>
                    <p class="small mb-3">You haven't submitted any recommendations yet.</p>
                    <a href="{{ route('recommendations.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-stars me-1"></i> Recommend a Resource Now
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Publisher</th>
                                <th>Year</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Librarian Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recommendations->take(6) as $rec)
                            @php
                                $statusClass = match($rec->status) {
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                    default    => 'warning text-dark',
                                };
                                $statusIcon = match($rec->status) {
                                    'approved' => 'bi-check-circle',
                                    'rejected' => 'bi-x-circle',
                                    default    => 'bi-hourglass-split',
                                };
                            @endphp
                            <tr>
                                <td>
                                    <div class="small fw-semibold text-truncate" style="max-width:180px;">
                                        {{ $rec->title }}
                                    </div>
                                    @if($rec->resource_url)
                                        <a href="{{ $rec->resource_url }}" target="_blank"
                                           class="text-muted" style="font-size:0.72rem;">
                                            <i class="bi bi-link-45deg"></i> Link
                                        </a>
                                    @endif
                                </td>
                                <td class="small text-muted">{{ $rec->author_name ?? '—' }}</td>
                                <td class="small text-muted">{{ $rec->publisher_name ?? '—' }}</td>
                                <td class="small text-muted">{{ $rec->publication_year ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-{{ $statusClass }}">
                                        <i class="bi {{ $statusIcon }} me-1"></i>
                                        {{ ucfirst($rec->status) }}
                                    </span>
                                </td>
                                <td class="small text-muted">{{ $rec->created_at->format('M d, Y') }}</td>
                                <td class="small text-muted fst-italic">
                                    {{ $rec->librarian_note ?? '—' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($recommendations->count() > 6)
                    <div class="mt-2 text-end">
                        <a href="{{ route('recommendations.index') }}" class="btn btn-sm btn-outline-secondary">
                            View All {{ $recommendations->count() }} Recommendations
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

@endsection