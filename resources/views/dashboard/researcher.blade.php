@extends('layouts.app')
@section('title', 'Researcher Dashboard')

@section('content')

@php
    $user        = auth()->user();
    $totalAccess = $user->accessLogs()->count();
    $totalDL     = $user->accessLogs()->where('access_type', 'download')->count();
    $bookmarks   = $user->bookmarks()->count();
    $requests    = \App\Models\ResourceRequest::where('user_id', $user->id)->get();
    $recentLogs   = $user->accessLogs()->with('eResource.category')->latest('accessed_at')->take(5)->get();
    $lastResource = $recentLogs->first()->eResource ?? null;
@endphp

{{-- ── Welcome Header ─────────────────────────────────────── --}}
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-mortarboard me-2"></i>Dashboard</h4>
        <small class="text-muted">Welcome back, {{ $user->full_name }}! Here's your research overview.</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('resource-requests.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-envelope-plus me-1"></i> Request Resource
        </a>
        <a href="{{ route('search.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-search me-1"></i> Browse
        </a>
    </div>
</div>

{{-- ── Stats Row ───────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card blue p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Accesses</div>
                    <div class="fs-3 fw-bold">{{ $totalAccess }}</div>
                </div>
                <i class="bi bi-eye fs-2 text-primary opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card green p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Downloads</div>
                    <div class="fs-3 fw-bold">{{ $totalDL }}</div>
                </div>
                <i class="bi bi-download fs-2 text-success opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card orange p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Bookmarks</div>
                    <div class="fs-3 fw-bold">{{ $bookmarks }}</div>
                </div>
                <i class="bi bi-bookmark-heart fs-2 text-warning opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card red p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Resource Requests</div>
                    <div class="fs-3 fw-bold">{{ $requests->count() }}</div>
                </div>
                <i class="bi bi-envelope-plus fs-2 text-danger opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">

    {{-- ── Recently Accessed ───────────────────────────────── --}}
    <div class="col-md-7">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-clock-history me-2 text-primary"></i>Recently Accessed
                </h6>
                <a href="{{ route('history.index') }}" class="btn btn-sm btn-outline-secondary">
                    View All
                </a>
            </div>
            @if($recentLogs->isEmpty())
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                    No resources accessed yet.
                </div>
            @else
                @foreach($recentLogs as $log)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div class="small fw-semibold">{{ $log->eResource->title }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">
                            {{ $log->eResource->category->name ?? '—' }}
                            &nbsp;·&nbsp;
                            {{ \Carbon\Carbon::parse($log->accessed_at)->diffForHumans() }}
                        </div>
                    </div>
                    <div class="d-flex gap-1 align-items-center">
                        <span class="badge bg-{{ $log->access_type === 'download' ? 'success' : 'secondary' }}">
                            {{ ucfirst($log->access_type) }}
                        </span>
                        <a href="{{ route('citations.show', $log->eResource) }}"
                           class="btn btn-sm btn-outline-secondary" title="Export Citation">
                            <i class="bi bi-quote"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- ── Resource Requests Status ────────────────────────── --}}
    <div class="col-md-5">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-envelope-plus me-2 text-danger"></i>My Resource Requests
                </h6>
                <a href="{{ route('resource-requests.index') }}" class="btn btn-sm btn-outline-secondary">
                    View All
                </a>
            </div>
            @if($requests->isEmpty())
                <div class="text-center py-3 text-muted">
                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                    <p class="small mb-2">No requests submitted yet.</p>
                    <a href="{{ route('resource-requests.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Request Now
                    </a>
                </div>
            @else
                @foreach($requests->take(4) as $req)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div class="small fw-semibold text-truncate" style="max-width:160px;">
                            {{ $req->title }}
                        </div>
                        <div class="text-muted" style="font-size:0.75rem;">
                            {{ $req->created_at->format('M d, Y') }}
                            &nbsp;·&nbsp;
                            <span class="text-{{ $req->urgency === 'high' ? 'danger' : ($req->urgency === 'medium' ? 'warning' : 'muted') }}">
                                {{ ucfirst($req->urgency) }} urgency
                            </span>
                        </div>
                    </div>
                    <span class="badge bg-{{ $req->status === 'fulfilled' ? 'success' : ($req->status === 'declined' ? 'danger' : ($req->status === 'processing' ? 'info text-dark' : 'warning text-dark')) }}">
                        {{ ucfirst($req->status) }}
                    </span>
                </div>
                @endforeach
                <div class="mt-2 text-end">
                    <a href="{{ route('resource-requests.create') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle me-1"></i> New Request
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- ── Quick Actions ───────────────────────────────────── --}}
    <div class="col-md-4">
        <div class="card p-3">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-lightning me-2 text-warning"></i>Quick Actions
            </h6>
            <div class="d-grid gap-2">
                <a href="{{ route('search.index') }}" class="btn btn-outline-primary text-start btn-sm">
                    <i class="bi bi-search me-2"></i>Browse E-Resources
                </a>
                <a href="{{ route('bookmarks.index') }}" class="btn btn-outline-warning text-start btn-sm">
                    <i class="bi bi-bookmark-heart me-2"></i>My Bookmarks
                </a>
                <a href="{{ route('history.index') }}" class="btn btn-outline-secondary text-start btn-sm">
                    <i class="bi bi-clock-history me-2"></i>Reading History
                </a>
                <a href="{{ route('resource-requests.create') }}" class="btn btn-outline-danger text-start btn-sm">
                    <i class="bi bi-envelope-plus me-2"></i>Request a Resource
                </a>

                {{-- Citation shortcut — links to last accessed resource --}}
                @if($lastResource)
                    <a href="{{ route('citations.show', $lastResource) }}"
                       class="btn btn-outline-secondary text-start btn-sm">
                        <i class="bi bi-quote me-2"></i>Export Citation
                        <span class="d-block text-muted" style="font-size:0.7rem; margin-top:1px;">
                            {{ \Illuminate\Support\Str::limit($lastResource->title, 30) }}
                        </span>
                    </a>
                @else
                    <button class="btn btn-outline-secondary text-start btn-sm disabled" disabled>
                        <i class="bi bi-quote me-2"></i>Export Citation
                        <span class="d-block text-muted" style="font-size:0.7rem; margin-top:1px;">
                            No resource accessed yet
                        </span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Browse by Category ──────────────────────────────── --}}
    <div class="col-md-8">
        <div class="card p-3">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-grid me-2 text-success"></i>Browse by Category
            </h6>
            <div class="row g-2">
                @foreach(\App\Models\Category::withCount('eResources')->get() as $cat)
                <div class="col-md-4">
                    <a href="{{ route('search.index', ['category_id' => $cat->id]) }}"
                       class="text-decoration-none">
                        <div class="border rounded p-2 text-center h-100"
                             style="transition:0.2s" onmouseover="this.style.background='#f0f4ff'"
                             onmouseout="this.style.background='white'">
                            <i class="bi bi-folder2-open fs-4 text-primary d-block mb-1"></i>
                            <div class="small fw-semibold">{{ $cat->name }}</div>
                            <div class="text-muted" style="font-size:0.72rem;">
                                {{ $cat->e_resources_count }} resource(s)
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection