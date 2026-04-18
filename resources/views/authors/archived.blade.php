@extends('layouts.app')
@section('title', 'Archived Authors')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-archive me-2"></i>Archived Authors</h4>
        <small class="text-muted">These authors are archived but still exist in the database.</small>
    </div>
    <a href="{{ route('authors.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Active
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Archived On</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($authors as $author)
                <tr class="table-warning">
                    <td class="text-muted small">{{ $author->id }}</td>
                    <td class="fw-semibold">{{ $author->full_name }}</td>
                    <td class="small text-muted">{{ $author->email ?? '—' }}</td>
                    <td class="small text-muted">{{ $author->deleted_at->format('M d, Y h:i A') }}</td>
                    <td class="text-center">
                        <form method="POST" action="{{ route('authors.restore', $author->id) }}" class="d-inline">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-outline-success">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                            </button>
                        </form>
                        <form method="POST" action="{{ route('authors.force-delete', $author->id) }}"
                              class="d-inline"
                              onsubmit="return confirm('Permanently delete this author?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash3 me-1"></i>Delete Forever
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="bi bi-archive fs-3 d-block mb-2"></i>No archived authors.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($authors->hasPages())
    <div class="card-footer">{{ $authors->links() }}</div>
    @endif
</div>
@endsection