@extends('layouts.app')
@section('title', 'Manage E-Resources')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-journals me-2"></i>E-Resources</h4>
        <small class="text-muted">Manage the library's digital collection</small>
    </div>
    <a href="{{ route('e-resources.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Add E-Resource
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Type</th>
                        <th>Year</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($eResources as $resource)
                    <tr>
                        <td class="text-muted small">{{ $resource->id }}</td>
                        <td class="fw-semibold" style="max-width:200px;">
                            <div class="text-truncate">{{ $resource->title }}</div>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $resource->category->name }}</span></td>
                        <td class="small">{{ $resource->author->full_name }}</td>
                        <td class="small text-muted">{{ $resource->publisher->name }}</td>
                        <td><span class="badge bg-primary">{{ $resource->file_type ?? '—' }}</span></td>
                        <td class="small text-muted">{{ $resource->publication_year ?? '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('e-resources.show', $resource) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('e-resources.edit', $resource) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('e-resources.destroy', $resource) }}" class="d-inline"
                                  onsubmit="return confirm('Delete this resource?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>No e-resources found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($eResources->hasPages())
    <div class="card-footer">{{ $eResources->links() }}</div>
    @endif
</div>
@endsection