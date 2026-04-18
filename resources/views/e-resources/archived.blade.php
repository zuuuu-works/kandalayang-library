@extends('layouts.app')
@section('title', 'Archived E-Resources')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-archive me-2"></i>Archived E-Resources</h4>
        <small class="text-muted">These resources are hidden from users but still exist in the database.</small>
    </div>
    <a href="{{ route('e-resources.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Active
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Type</th>
                    <th>Archived On</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($eResources as $resource)
                <tr class="table-warning">
                    <td class="text-muted small">{{ $resource->id }}</td>
                    <td class="fw-semibold" style="max-width:200px;">
                        <div class="text-truncate">{{ $resource->title }}</div>
                    </td>
                    <td><span class="badge bg-light text-dark border">{{ $resource->category->name }}</span></td>
                    <td class="small">{{ $resource->author->full_name }}</td>
                    <td><span class="badge bg-secondary">{{ $resource->file_type ?? '—' }}</span></td>
                    <td class="small text-muted">{{ $resource->deleted_at->format('M d, Y h:i A') }}</td>
                    <td class="text-center">
                        {{-- Restore --}}
                        <form method="POST" action="{{ route('e-resources.restore', $resource->id) }}" class="d-inline">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-outline-success" title="Restore">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                            </button>
                        </form>

                        {{-- Permanent Delete --}}
                        <form method="POST" action="{{ route('e-resources.force-delete', $resource->id) }}"
                              class="d-inline"
                              onsubmit="return confirm('Permanently delete this resource? This CANNOT be undone!')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Delete Forever">
                                <i class="bi bi-trash3 me-1"></i>Delete Forever
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-archive fs-3 d-block mb-2"></i>No archived e-resources.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($eResources->hasPages())
    <div class="card-footer">{{ $eResources->links() }}</div>
    @endif
</div>
@endsection