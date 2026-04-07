@extends('layouts.app')
@section('title', 'My Bookmarks')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-bookmark-heart me-2"></i>My Bookmarks</h4>
        <small class="text-muted">Your saved e-resources for easy access</small>
    </div>
    <a href="{{ route('search.index') }}" class="btn btn-sm btn-outline-primary">
        <i class="bi bi-search me-1"></i> Browse More Resources
    </a>
</div>

@if($bookmarks->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-bookmark fs-1 text-muted d-block mb-3"></i>
        <h5 class="text-muted">No bookmarks yet</h5>
        <p class="text-muted small">Browse resources and click the bookmark icon to save them here.</p>
        <a href="{{ route('search.index') }}" class="btn btn-primary mt-2">
            <i class="bi bi-search me-1"></i> Browse Resources
        </a>
    </div>
@else
<div class="row g-3">
    @foreach($bookmarks as $bookmark)
    @php $resource = $bookmark->eResource; @endphp
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-light text-dark border">{{ $resource->category->name }}</span>
                    <span class="badge bg-primary">{{ $resource->file_type ?? 'N/A' }}</span>
                </div>
                <h6 class="fw-bold mb-1">{{ $resource->title }}</h6>
                <p class="text-muted small mb-2">
                    <i class="bi bi-person me-1"></i>{{ $resource->author->full_name }}
                    &nbsp;·&nbsp;
                    <i class="bi bi-building me-1"></i>{{ $resource->publisher->name }}
                </p>
                <p class="text-muted small mb-3" style="font-size:0.8rem;">
                    {{ Str::limit($resource->description, 80) }}
                </p>

                <div class="d-flex gap-2">
                    {{-- View button --}}
                    <a href="{{ route('file.access', ['eResource' => $resource, 'type' => 'view']) }}"
                       target="_blank" class="btn btn-sm btn-outline-primary flex-grow-1">
                        <i class="bi bi-eye me-1"></i> View
                    </a>

                    {{-- Remove bookmark button --}}
                    <form method="POST" action="{{ route('bookmarks.destroy', $bookmark) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Remove Bookmark">
                            <i class="bi bi-bookmark-x"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-footer bg-transparent text-muted small">
                <i class="bi bi-clock me-1"></i>Saved {{ $bookmark->created_at->diffForHumans() }}
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-4">
    {{ $bookmarks->links() }}
</div>
@endif
@endsection