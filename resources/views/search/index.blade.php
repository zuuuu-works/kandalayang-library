@extends('layouts.app')
@section('title', 'Search E-Resources')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-search me-2"></i>Search E-Resources</h4>
    <small class="text-muted">Browse and access the library's digital collection</small>
</div>

{{-- Search & Filter Form --}}
<div class="card p-3 mb-4">
    <form method="GET" action="{{ route('search.index') }}" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-semibold small">Keyword</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="keyword" class="form-control" placeholder="Title, description, ISBN..."
                       value="{{ request('keyword') }}">
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold small">Category</label>
            <select name="category_id" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold small">File Type</label>
            <select name="file_type" class="form-select">
                <option value="">All Types</option>
                <option value="PDF"  {{ request('file_type') === 'PDF'  ? 'selected' : '' }}>PDF</option>
                <option value="ePub" {{ request('file_type') === 'ePub' ? 'selected' : '' }}>ePub</option>
                <option value="MP3"  {{ request('file_type') === 'MP3'  ? 'selected' : '' }}>MP3</option>
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

{{-- Results --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <small class="text-muted">{{ $eResources->total() }} resource(s) found</small>
</div>

@if($eResources->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        No resources found. Try a different search.
    </div>
@else
<div class="row g-3">
    @foreach($eResources as $resource)
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
                <p class="text-muted small mb-3" style="font-size:0.8rem; line-height:1.4;">
                    {{ Str::limit($resource->description, 90) }}
                </p>
                <div class="d-flex gap-2">
                    <form method="POST" action="{{ route('search.access', $resource) }}" class="flex-grow-1">
                        @csrf
                        <input type="hidden" name="access_type" value="view">
                        <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                            <i class="bi bi-eye me-1"></i>View
                        </button>
                    </form>
                    <form method="POST" action="{{ route('search.access', $resource) }}">
                        @csrf
                        <input type="hidden" name="access_type" value="download">
                        <button type="submit" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-download"></i>
                        </button>
                    </form>
                </div>
            </div>
            @if($resource->publication_year)
            <div class="card-footer bg-transparent text-muted small">
                <i class="bi bi-calendar3 me-1"></i>Published {{ $resource->publication_year }}
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>

<div class="mt-4">
    {{ $eResources->links() }}
</div>
@endif
@endsection