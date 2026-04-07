@extends('layouts.app')
@section('title', 'Resource Recommendations')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-star me-2"></i>Resource Recommendations</h4>
    <small class="text-muted">Review and act on faculty recommendations</small>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Recommended By</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recommendations as $rec)
                <tr>
                    <td>
                        <div class="fw-semibold small">{{ $rec->title }}</div>
                        @if($rec->reason)
                        <div class="text-muted" style="font-size:0.75rem;">{{ Str::limit($rec->reason, 60) }}</div>
                        @endif
                    </td>
                    <td class="small text-muted">{{ $rec->author_name }}</td>
                    <td class="small">{{ $rec->user->full_name }}</td>
                    <td>
                        <span class="badge bg-{{ $rec->status === 'approved' ? 'success' : ($rec->status === 'rejected' ? 'danger' : 'warning text-dark') }}">
                            {{ ucfirst($rec->status) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $rec->created_at->format('M d, Y') }}</td>
                    <td class="text-center">
                        @if($rec->status === 'pending')
                        <form method="POST" action="{{ route('recommendations.status', $rec) }}" class="d-inline">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button class="btn btn-sm btn-outline-success" title="Approve">
                                <i class="bi bi-check-circle"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('recommendations.status', $rec) }}" class="d-inline">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button class="btn btn-sm btn-outline-danger" title="Reject">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </form>
                        @else
                            <span class="text-muted small">Done</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>No recommendations yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($recommendations->hasPages())
    <div class="card-footer">{{ $recommendations->links() }}</div>
    @endif
</div>
@endsection