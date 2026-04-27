@extends('layouts.app')
@section('title', 'Manage Publishers')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-building me-2"></i>Publishers</h4>
        <small class="text-muted">Manage all publishers in the system</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('publishers.archived') }}" class="btn btn-sm btn-outline-warning">
            <i class="bi bi-archive me-1"></i> View Archived
        </a>
        <a href="{{ route('publishers.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Add Publisher
        </a>
    </div>
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
            <tbody id="publishers-tbody">
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
                              onsubmit="return confirm('Archive this publisher?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Archive">
                                <i class="bi bi-archive"></i>
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

    {{-- Loading Spinner --}}
    <div id="loading-spinner" class="text-center py-3" style="display:none;">
        <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
        <span class="text-muted small">Loading more publishers...</span>
    </div>

    {{-- End of Results --}}
    <div id="end-of-results" class="text-center py-3 text-muted small" style="display:none;">
        <i class="bi bi-check-circle me-1 text-success"></i>
        Showing all {{ $publishers->total() }} publisher(s).
    </div>
</div>

{{-- Pagination data --}}
<div id="pagination-data"
     data-next-page="{{ $publishers->nextPageUrl() }}"
     data-current-page="{{ $publishers->currentPage() }}"
     data-last-page="{{ $publishers->lastPage() }}"
     style="display:none;">
</div>

@endsection

@push('scripts')
<script>
(function () {
    const tbody      = document.getElementById('publishers-tbody');
    const spinner    = document.getElementById('loading-spinner');
    const endMsg     = document.getElementById('end-of-results');
    const pagination = document.getElementById('pagination-data');

    if (!tbody || !pagination) return;

    let isLoading   = false;
    let nextPage    = pagination.dataset.nextPage;
    let currentPage = parseInt(pagination.dataset.currentPage);
    let lastPage    = parseInt(pagination.dataset.lastPage);

    // Show end message if only 1 page
    if (currentPage >= lastPage) {
        if (endMsg) endMsg.style.display = 'block';
        return;
    }

    // ── Sentinel at bottom ────────────────────────────────────
    const sentinel = document.createElement('div');
    sentinel.style.height = '1px';
    document.querySelector('.card').appendChild(sentinel);

    const observer = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting && !isLoading && nextPage) {
            loadMore();
        }
    }, { rootMargin: '150px' });

    observer.observe(sentinel);

    // ── Fetch and append rows ─────────────────────────────────
    async function loadMore() {
        if (isLoading || !nextPage) return;

        isLoading = true;
        spinner.style.display = 'block';

        try {
            const response = await fetch(nextPage, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) throw new Error('Network error');

            const html   = await response.text();
            const parser = new DOMParser();
            const doc    = parser.parseFromString(html, 'text/html');

            // Append new rows
            const newRows = doc.querySelectorAll('#publishers-tbody tr');
            newRows.forEach(row => tbody.appendChild(row));

            // Update pagination info
            const newPagination = doc.getElementById('pagination-data');
            if (newPagination) {
                nextPage    = newPagination.dataset.nextPage || null;
                currentPage = parseInt(newPagination.dataset.currentPage);
                lastPage    = parseInt(newPagination.dataset.lastPage);
            } else {
                nextPage = null;
            }

            // Show end message if done
            if (!nextPage || currentPage >= lastPage) {
                endMsg.style.display = 'block';
                observer.disconnect();
            }

        } catch (error) {
            console.error('Infinite scroll error:', error);
        } finally {
            isLoading = false;
            spinner.style.display = 'none';
        }
    }
})();
</script>
@endpush