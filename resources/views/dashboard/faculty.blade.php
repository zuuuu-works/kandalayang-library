@extends('layouts.app')
@section('title', ucfirst(auth()->user()->role) . ' Dashboard')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
    <small class="text-muted">Welcome back, {{ auth()->user()->full_name }}!</small>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
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
    <div class="col-md-4">
        <div class="card stat-card green p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">My Total Accesses</div>
                    <div class="fs-4 fw-bold">{{ auth()->user()->accessLogs()->count() }}</div>
                </div>
                <i class="bi bi-clock-history fs-2 text-success opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
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
</div>

<div class="row g-3">
    {{-- Recently Accessed --}}
    <div class="col-md-7">
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-primary"></i>My Recent Accesses</h6>
            @php $myLogs = auth()->user()->accessLogs()->with('eResource')->latest('accessed_at')->take(6)->get(); @endphp
            @if($myLogs->isEmpty())
                <p class="text-muted text-center py-3">You haven't accessed any resources yet.</p>
            @else
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Resource</th><th>Type</th><th>When</th></tr>
                    </thead>
                    <tbody>
                        @foreach($myLogs as $log)
                        <tr>
                            <td class="text-truncate" style="max-width:200px;">{{ $log->eResource->title }}</td>
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

    {{-- Quick Access --}}
    <div class="col-md-5">
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-lightning me-2 text-warning"></i>Quick Actions</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('search.index') }}" class="btn btn-primary text-start">
                    <i class="bi bi-search me-2"></i>Browse & Search Resources
                </a>
                <a href="{{ route('search.index') }}?file_type=PDF" class="btn btn-outline-secondary text-start">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Browse PDFs
                </a>
                <a href="{{ route('search.index') }}?file_type=ePub" class="btn btn-outline-secondary text-start">
                    <i class="bi bi-book me-2"></i>Browse ePubs
                </a>
            </div>
        </div>
    </div>
</div>
@endsection