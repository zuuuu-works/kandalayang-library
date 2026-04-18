@extends('layouts.app')
@section('title', 'Archived Publishers')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-archive me-2"></i>Archived Publishers</h4>
        <small class="text-muted">These publishers are archived but still exist in the database.</small>
    </div>
    <a href="{{ route('publishers.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Active
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Website</th>
                    <th>Archived On</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($publishers as $publisher)
                <tr class="table-warning">
                    <td class="text-muted small">{{ $publisher->id }}</td>
                    <td class="fw-semibold">{{ $publisher->name }}</td>
                    <td class="small text-muted">{{ $publisher->email ?? '—' }}</td>
                    <td class="small">
                        @if($publisher->website)
                            <a href="{{ $publisher->website }}" target="_blank" class="text-decoration-none">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Visit
                            </a>
                        @else —
                        @endif
                    </td>
                    <td class="small text-muted">{{ $publisher->deleted_at->format('M d, Y h:i A') }}</td>
                    <td class="text-center">
                        <form method="POST" action="{{ route('publishers.restore', $publisher->id) }}" class="d-inline">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-outline-success">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                            </button>
                        </form>
                        <form method="POST" action="{{ route('publishers.force-delete', $publisher->id) }}"
                              class="d-inline"
                              onsubmit="return confirm('Permanently delete this publisher?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash3 me-1"></i>Delete Forever
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-archive fs-3 d-block mb-2"></i>No archived publishers.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($publishers->hasPages())
    <div class="card-footer">{{ $publishers->links() }}</div>
    @endif
</div>
@endsection