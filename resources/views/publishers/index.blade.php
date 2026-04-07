@extends('layouts.app')
@section('title', 'Manage Publishers')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-building me-2"></i>Publishers</h4>
        <small class="text-muted">Manage all publishers in the system</small>
    </div>
    <a href="{{ route('publishers.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Add Publisher
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
                    <th>Address</th>
                    <th class="text-center">E-Resources</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($publishers as $publisher)
                <tr>
                    <td class="text-muted small">{{ $publisher->id }}</td>
                    <td class="fw-semibold">{{ $publisher->name }}</td>
                    <td class="small text-muted">{{ $publisher->email ?? '—' }}</td>
                    <td class="small">
                        @if($publisher->website)
                            <a href="{{ $publisher->website }}" target="_blank" class="text-decoration-none">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Visit
                            </a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="small text-muted" style="max-width:180px;">
                        <div class="text-truncate">{{ $publisher->address ?? '—' }}</div>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-primary rounded-pill">{{ $publisher->e_resources_count }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('publishers.edit', $publisher) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('publishers.destroy', $publisher) }}" class="d-inline"
                              onsubmit="return confirm('Delete this publisher?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>No publishers yet.
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