@extends('layouts.app')
@section('title', 'Manage Authors')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-person-lines-fill me-2"></i>Authors</h4>
        <small class="text-muted">Manage all authors in the system</small>
    </div>
    <a href="{{ route('authors.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Add Author
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
                    <th>Bio</th>
                    <th class="text-center">E-Resources</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($authors as $author)
                <tr>
                    <td class="text-muted small">{{ $author->id }}</td>
                    <td class="fw-semibold">{{ $author->full_name }}</td>
                    <td class="small text-muted">{{ $author->email ?? '—' }}</td>
                    <td class="small text-muted" style="max-width:200px;">
                        <div class="text-truncate">{{ $author->bio ?? '—' }}</div>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-primary rounded-pill">{{ $author->e_resources_count }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('authors.edit', $author) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('authors.destroy', $author) }}" class="d-inline"
                              onsubmit="return confirm('Delete this author?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>No authors yet.
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