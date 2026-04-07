@extends('layouts.app')
@section('title', 'View E-Resource')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-journal-text me-2"></i>E-Resource Details</h4>
        <small class="text-muted">Viewing full details of this resource</small>
    </div>
    <div class="d-flex gap-2">
        @if(auth()->user()->isLibrarian())
        <a href="{{ route('e-resources.edit', $eResource) }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        @endif
        <a href="{{ route('e-resources.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-3">
    {{-- Main Info --}}
    <div class="col-md-8">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="badge bg-light text-dark border mb-2">{{ $eResource->category->name }}</span>
                    <h5 class="fw-bold mb-1">{{ $eResource->title }}</h5>
                    <p class="text-muted small mb-0">
                        <i class="bi bi-person me-1"></i>{{ $eResource->author->full_name }}
                        &nbsp;·&nbsp;
                        <i class="bi bi-building me-1"></i>{{ $eResource->publisher->name }}
                        @if($eResource->publication_year)
                            &nbsp;·&nbsp;
                            <i class="bi bi-calendar3 me-1"></i>{{ $eResource->publication_year }}
                        @endif
                    </p>
                </div>
                <span class="badge bg-primary fs-6">{{ $eResource->file_type ?? 'N/A' }}</span>
            </div>

            <hr>

            {{-- Description --}}
            <div class="mb-3">
                <div class="fw-semibold small text-muted mb-1">DESCRIPTION</div>
                <p class="mb-0">{{ $eResource->description ?? 'No description provided.' }}</p>
            </div>

            {{-- ISBN --}}
            @if($eResource->isbn)
            <div class="mb-3">
                <div class="fw-semibold small text-muted mb-1">ISBN</div>
                <p class="mb-0">{{ $eResource->isbn }}</p>
            </div>
            @endif

            {{-- Access Buttons --}}
            <hr>
            <div class="fw-semibold small text-muted mb-2">ACCESS THIS RESOURCE</div>
            @if($eResource->hasFile())
                <div class="d-flex gap-2">
                    <a href="{{ route('file.access', ['eResource' => $eResource, 'type' => 'view']) }}"
                       target="_blank" class="btn btn-primary">
                        <i class="bi bi-eye me-1"></i> View / Open
                    </a>
                    <a href="{{ route('file.access', ['eResource' => $eResource, 'type' => 'download']) }}"
                       class="btn btn-outline-success">
                        <i class="bi bi-download me-1"></i> Download
                    </a>
                </div>
            @else
                <div class="alert alert-warning py-2 mb-0">
                    <i class="bi bi-exclamation-triangle me-2"></i>No file or URL attached to this resource yet.
                </div>
            @endif
        </div>
    </div>

    {{-- Side Info --}}
    <div class="col-md-4">
        {{-- Bibliographic Details --}}
        <div class="card p-3 mb-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Bibliographic Info</h6>
            <table class="table table-sm table-borderless mb-0">
                <tr>
                    <td class="text-muted small">Author</td>
                    <td class="small fw-semibold">{{ $eResource->author->full_name }}</td>
                </tr>
                <tr>
                    <td class="text-muted small">Publisher</td>
                    <td class="small fw-semibold">{{ $eResource->publisher->name }}</td>
                </tr>
                <tr>
                    <td class="text-muted small">Category</td>
                    <td class="small fw-semibold">{{ $eResource->category->name }}</td>
                </tr>
                <tr>
                    <td class="text-muted small">File Type</td>
                    <td class="small fw-semibold">{{ $eResource->file_type ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="text-muted small">Year</td>
                    <td class="small fw-semibold">{{ $eResource->publication_year ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="text-muted small">ISBN</td>
                    <td class="small fw-semibold">{{ $eResource->isbn ?? '—' }}</td>
                </tr>
            </table>
        </div>

        {{-- Access Log Summary (Librarian only) --}}
        @if(auth()->user()->isLibrarian())
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-warning"></i>Recent Accesses</h6>
            @php $logs = $eResource->accessLogs()->with('user')->latest('accessed_at')->take(5)->get(); @endphp
            @if($logs->isEmpty())
                <p class="text-muted small text-center py-2">No accesses yet.</p>
            @else
                @foreach($logs as $log)
                <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                    <div>
                        <div class="small fw-semibold">{{ $log->user->full_name }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">{{ $log->accessed_at->diffForHumans() }}</div>
                    </div>
                    <span class="badge bg-{{ $log->access_type === 'download' ? 'success' : 'secondary' }}">
                        {{ ucfirst($log->access_type) }}
                    </span>
                </div>
                @endforeach
                <div class="mt-2 text-end">
                    <a href="{{ route('reports.access-logs', ['e_resource_id' => $eResource->id]) }}"
                       class="btn btn-sm btn-outline-secondary">View All</a>
                </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection