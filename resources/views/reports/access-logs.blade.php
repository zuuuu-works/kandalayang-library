@extends('layouts.app')
@section('title', 'Access Logs')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-clock-history me-2"></i>Access Logs</h4>
    <small class="text-muted">Detailed record of every resource access</small>
</div>

{{-- Filters --}}
<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('reports.access-logs') }}" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label small fw-semibold">User</label>
            <select name="user_id" class="form-select form-select-sm">
                <option value="">All Users</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->full_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">E-Resource</label>
            <select name="e_resource_id" class="form-select form-select-sm">
                <option value="">All Resources</option>
                @foreach($eResources as $res)
                    <option value="{{ $res->id }}" {{ request('e_resource_id') == $res->id ? 'selected' : '' }}>
                        {{ Str::limit($res->title, 40) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-semibold">Access Type</label>
            <select name="access_type" class="form-select form-select-sm">
                <option value="">All Types</option>
                <option value="view"     {{ request('access_type') === 'view'     ? 'selected' : '' }}>View</option>
                <option value="download" {{ request('access_type') === 'download' ? 'selected' : '' }}>Download</option>
                <option value="stream"   {{ request('access_type') === 'stream'   ? 'selected' : '' }}>Stream</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-semibold">Date From</label>
            <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-1">
            <label class="form-label small fw-semibold">To</label>
            <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-1 d-flex gap-1">
            <button type="submit" class="btn btn-sm btn-primary w-100">Go</button>
            <a href="{{ route('reports.access-logs') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x"></i></a>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>E-Resource</th>
                    <th>Access Type</th>
                    <th>Accessed At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="text-muted small">{{ $log->id }}</td>
                    <td class="fw-semibold small">{{ $log->user->full_name }}</td>
                    <td>
                        <span class="badge bg-secondary" style="font-size:0.65rem;">{{ $log->user->role }}</span>
                    </td>
                    <td class="small text-truncate" style="max-width:200px;">{{ $log->eResource->title }}</td>
                    <td>
                        <span class="badge bg-{{ $log->access_type === 'download' ? 'success' : ($log->access_type === 'stream' ? 'warning text-dark' : 'secondary') }}">
                            {{ ucfirst($log->access_type) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $log->accessed_at->format('M d, Y h:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>No access logs found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="card-footer">{{ $logs->links() }}</div>
    @endif
</div>
@endsection