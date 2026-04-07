@extends('layouts.app')
@section('title', 'Reading History')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-clock-history me-2"></i>Reading History</h4>
        <small class="text-muted">All e-resources you have accessed</small>
    </div>
    <a href="{{ route('search.index') }}" class="btn btn-sm btn-outline-primary">
        <i class="bi bi-search me-1"></i> Browse Resources
    </a>
</div>

@if($history->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-clock fs-1 d-block mb-3"></i>
        <h5>No history yet</h5>
        <p class="small">Start browsing and accessing resources to build your history.</p>
        <a href="{{ route('search.index') }}" class="btn btn-primary mt-2">Browse Resources</a>
    </div>
@else
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>E-Resource</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Access Type</th>
                    <th>Accessed</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $log)
                <tr>
                    <td>
                        <div class="fw-semibold small">{{ $log->eResource->title }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">
                            {{ $log->eResource->author->full_name }}
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $log->eResource->category->name }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-primary">{{ $log->eResource->file_type ?? 'N/A' }}</span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $log->access_type === 'download' ? 'success' : ($log->access_type === 'stream' ? 'warning text-dark' : 'secondary') }}">
                            {{ ucfirst($log->access_type) }}
                        </span>
                    </td>
                    <td class="small text-muted">
                        {{ \Carbon\Carbon::parse($log->accessed_at)->format('M d, Y h:i A') }}
                    </td>
                    <td>
                        <a href="{{ route('file.access', ['eResource' => $log->eResource, 'type' => 'view']) }}"
                           target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye me-1"></i>View Again
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($history->hasPages())
    <div class="card-footer">{{ $history->links() }}</div>
    @endif
</div>
@endif
@endsection