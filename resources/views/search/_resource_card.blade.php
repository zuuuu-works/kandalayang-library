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
                {{-- View --}}
                <form method="POST" action="{{ route('search.access', $resource) }}" class="flex-grow-1">
                    @csrf
                    <input type="hidden" name="access_type" value="view">
                    <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-eye me-1"></i>View
                    </button>
                </form>

                {{-- Download --}}
                <form method="POST" action="{{ route('search.access', $resource) }}">
                    @csrf
                    <input type="hidden" name="access_type" value="download">
                    <button type="submit" class="btn btn-sm btn-outline-success" title="Download">
                        <i class="bi bi-download"></i>
                    </button>
                </form>

                {{-- Citation --}}
                <a href="{{ route('citations.show', $resource) }}"
                   class="btn btn-sm btn-outline-secondary" title="Export Citation">
                    <i class="bi bi-quote"></i>
                </a>

                {{-- Bookmark toggle --}}
                <form method="POST" action="{{ route('bookmarks.toggle', $resource) }}">
                    @csrf
                    @php $isBookmarked = auth()->user()->hasBookmarked($resource->id); @endphp
                    <button type="submit"
                            class="btn btn-sm {{ $isBookmarked ? 'btn-warning' : 'btn-outline-warning' }}"
                            title="{{ $isBookmarked ? 'Remove Bookmark' : 'Bookmark this' }}">
                        <i class="bi bi-bookmark{{ $isBookmarked ? '-fill' : '' }}"></i>
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