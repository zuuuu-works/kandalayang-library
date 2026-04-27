@extends('layouts.app')
@section('title', 'Search E-Resources')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-search me-2"></i>Search E-Resources</h4>
        <small class="text-muted">Browse and access the library's digital collection</small>
    </div>
    <a href="{{ route('bookmarks.index') }}" class="btn btn-sm btn-outline-warning">
        <i class="bi bi-bookmark-heart me-1"></i> My Bookmarks
        @php $bookmarkCount = auth()->user()->bookmarks()->count(); @endphp
        @if($bookmarkCount > 0)
            <span class="badge bg-warning text-dark ms-1">{{ $bookmarkCount }}</span>
        @endif
    </a>
</div>

{{-- ── Search & Filter Form ─────────────────────────────────── --}}
<div class="card p-3 mb-4">
    <form id="search-form" method="GET" action="{{ route('search.index') }}" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-semibold small">Keyword</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="keyword" id="keyword" class="form-control"
                       placeholder="Title, description, ISBN..."
                       value="{{ request('keyword') }}">
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold small">Category</label>
            <select name="category_id" id="category_id" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold small">File Type</label>
            <select name="file_type" id="file_type" class="form-select">
                <option value="">All Types</option>
                <option value="PDF"  {{ request('file_type') === 'PDF'  ? 'selected' : '' }}>PDF</option>
                <option value="EPUB" {{ request('file_type') === 'EPUB' ? 'selected' : '' }}>EPUB</option>
                <option value="MP3"  {{ request('file_type') === 'MP3'  ? 'selected' : '' }}>MP3</option>
                <option value="MP4"  {{ request('file_type') === 'MP4'  ? 'selected' : '' }}>MP4</option>
                <option value="DOCX" {{ request('file_type') === 'DOCX' ? 'selected' : '' }}>DOCX</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search me-1"></i> Search
            </button>
            <a href="{{ route('search.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-lg"></i>
            </a>
        </div>
    </form>
</div>

{{-- ── Results Count ────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <small class="text-muted">
        <span id="result-count">{{ $eResources->total() }}</span> resource(s) found
    </small>
</div>

{{-- ── Resource Cards Grid ──────────────────────────────────── --}}
@if($eResources->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        No resources found. Try a different search.
    </div>
@else
    <div id="resources-grid" class="row g-3">
        @foreach($eResources as $resource)
            @include('search._resource_card', ['resource' => $resource])
        @endforeach
    </div>

    {{-- Infinite Scroll Trigger --}}
    <div id="scroll-trigger" class="text-center py-4" style="display:none !important;">
        {{-- next page url stored here --}}
    </div>

    {{-- Loading Spinner --}}
    <div id="loading-spinner" class="text-center py-4" style="display:none;">
        <div class="spinner-border text-primary" role="status" style="width:2rem; height:2rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="text-muted small mt-2">Loading more resources...</div>
    </div>

    {{-- End of Results --}}
    <div id="end-of-results" class="text-center py-4 text-muted" style="display:none;">
        <i class="bi bi-check-circle me-2 text-success"></i>
        You've seen all {{ $eResources->total() }} resource(s).
    </div>

    {{-- Store pagination data --}}
    <div id="pagination-data"
         data-next-page="{{ $eResources->nextPageUrl() }}"
         data-current-page="{{ $eResources->currentPage() }}"
         data-last-page="{{ $eResources->lastPage() }}"
         style="display:none;">
    </div>
@endif

@endsection

@push('scripts')
<script>
(function () {
    const grid        = document.getElementById('resources-grid');
    const spinner     = document.getElementById('loading-spinner');
    const endMsg      = document.getElementById('end-of-results');
    const pagination  = document.getElementById('pagination-data');

    if (!grid || !pagination) return;

    let isLoading  = false;
    let nextPage   = pagination.dataset.nextPage;
    let lastPage   = parseInt(pagination.dataset.lastPage);
    let currentPage= parseInt(pagination.dataset.currentPage);

    // If only 1 page, show end message right away
    if (currentPage >= lastPage) {
        if (endMsg) endMsg.style.display = 'block';
        return;
    }

    // ── Intersection Observer (triggers when user nears bottom) ──
    const sentinel = document.createElement('div');
    sentinel.style.height = '1px';
    grid.parentNode.insertBefore(sentinel, grid.nextSibling);

    const observer = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting && !isLoading && nextPage) {
            loadMore();
        }
    }, { rootMargin: '200px' }); // trigger 200px before bottom

    observer.observe(sentinel);

    // ── Load Next Page ────────────────────────────────────────────
    async function loadMore() {
        if (isLoading || !nextPage) return;

        isLoading = true;
        spinner.style.display = 'block';

        try {
            const response = await fetch(nextPage, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) throw new Error('Network error');

            const html = await response.text();

            // Parse response HTML and extract card elements
            const parser   = new DOMParser();
            const doc      = parser.parseFromString(html, 'text/html');
            const newCards = doc.querySelectorAll('#resources-grid .col-md-4');
            const newPagination = doc.getElementById('pagination-data');

            // Append new cards to grid
            newCards.forEach(card => grid.appendChild(card));

            // Update pagination info
            if (newPagination) {
                nextPage    = newPagination.dataset.nextPage || null;
                currentPage = parseInt(newPagination.dataset.currentPage);
                lastPage    = parseInt(newPagination.dataset.lastPage);
            } else {
                nextPage = null;
            }

            // Show end message if no more pages
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