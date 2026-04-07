@extends('layouts.app')
@section('title', 'View User')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-person-circle me-2"></i>User Details</h4>
        <small class="text-muted">Viewing profile of {{ $user->full_name }}</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-3">
    {{-- User Info Card --}}
    <div class="col-md-4">
        <div class="card p-4 text-center mb-3">
            <div class="mb-3">
                <div style="width:80px;height:80px;border-radius:50%;background:#1a3c5e;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                    <span style="font-size:2rem;color:white;font-weight:700;">
                        {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                    </span>
                </div>
            </div>
            <h5 class="fw-bold mb-1">{{ $user->full_name }}</h5>
            <p class="text-muted small mb-2">{{ $user->email }}</p>
            <div class="d-flex justify-content-center gap-2 mb-3">
                <span class="badge rounded-pill
                    bg-{{ $user->role === 'librarian' ? 'dark' : ($user->role === 'faculty' ? 'info text-dark' : ($user->role === 'researcher' ? 'warning text-dark' : 'secondary')) }}">
                    {{ ucfirst($user->role) }}
                </span>
                <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                    {{ ucfirst($user->status) }}
                </span>
            </div>
            <div class="text-muted small">Registered {{ $user->created_at->format('M d, Y') }}</div>
        </div>

        {{-- Quick Actions --}}
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-lightning me-2 text-warning"></i>Quick Actions</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary btn-sm text-start">
                    <i class="bi bi-pencil me-2"></i>Edit User
                </a>
                @if($user->status === 'active')
                    <form method="POST" action="{{ route('users.deactivate', $user) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-danger btn-sm w-100 text-start"
                                onclick="return confirm('Deactivate this user?')">
                            <i class="bi bi-person-x me-2"></i>Deactivate Account
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('users.activate', $user) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-success btn-sm w-100 text-start">
                            <i class="bi bi-person-check me-2"></i>Activate Account
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Access History --}}
    <div class="col-md-8">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-clock-history me-2 text-primary"></i>
                    Access History
                    <span class="badge bg-primary rounded-pill ms-1">{{ $user->accessLogs->count() }}</span>
                </h6>
                <a href="{{ route('reports.access-logs', ['user_id' => $user->id]) }}"
                   class="btn btn-sm btn-outline-secondary">
                    View All in Reports
                </a>
            </div>

            @if($user->accessLogs->isEmpty())
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                    This user hasn't accessed any resources yet.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>E-Resource</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Accessed At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->accessLogs->sortByDesc('accessed_at')->take(15) as $log)
                            <tr>
                                <td class="small fw-semibold text-truncate" style="max-width:200px;">
                                    {{ $log->eResource->title ?? '—' }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $log->access_type === 'download' ? 'success' : ($log->access_type === 'stream' ? 'warning text-dark' : 'secondary') }}">
                                        {{ ucfirst($log->access_type) }}
                                    </span>
                                </td>
                                <td class="small text-muted">
                                    {{ $log->eResource->category->name ?? '—' }}
                                </td>
                                <td class="small text-muted">
                                    {{ \Carbon\Carbon::parse($log->accessed_at)->format('M d, Y h:i A') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($user->accessLogs->count() > 15)
                    <div class="text-center mt-2">
                        <small class="text-muted">Showing 15 of {{ $user->accessLogs->count() }} records.
                            <a href="{{ route('reports.access-logs', ['user_id' => $user->id]) }}">View all</a>
                        </small>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection