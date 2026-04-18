@extends('layouts.app')
@section('title', 'View E-Resource')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-journal-text me-2"></i>{{ $eResource->title }}</h4>
        <small class="text-muted">E-Resource Details</small>
    </div>

    <div class="d-flex gap-2">
        @if(auth()->user()->isLibrarian())
        <a href="{{ route('e-resources.edit', $eResource) }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        @endif

        <a href="{{ route('e-resources.index') }}" class="btn btn-sm btn-outline-secondary">
            Back
        </a>
    </div>
</div>

<div class="row g-3">

    {{-- MAIN --}}
    <div class="col-md-8">
        <div class="card p-4">

            <span class="badge bg-light text-dark border mb-2">
                {{ $eResource->category->name ?? '—' }}
            </span>

            <h5 class="fw-bold">{{ $eResource->title }}</h5>

            <p class="text-muted small">
                {{ $eResource->author->full_name ?? '—' }} ·
                {{ $eResource->publisher->name ?? '—' }} ·
                {{ $eResource->publication_year ?? '—' }}
            </p>

            <hr>

            <p>{{ $eResource->description ?? 'No description available.' }}</p>

            <hr>

            {{-- ACCESS --}}
            <h6 class="text-muted">ACCESS</h6>

            @if($eResource->file_path)

                <iframe src="{{ route('file.access', ['eResource' => $eResource, 'type' => 'view']) }}"
                        width="100%" height="500px"></iframe>

                <div class="mt-2 d-flex gap-2">
                    <a href="{{ route('file.access', ['eResource' => $eResource, 'type' => 'download']) }}"
                       class="btn btn-success btn-sm">
                        Download
                    </a>
                </div>

            @elseif($eResource->file_url)

                <iframe src="{{ $eResource->file_url }}"
                        width="100%" height="500px"></iframe>

                <a href="{{ $eResource->file_url }}" target="_blank"
                   class="btn btn-info btn-sm mt-2">
                    Open External Link
                </a>

            @else
                <div class="alert alert-warning">
                    No file or link attached.
                </div>
            @endif

        </div>
    </div>

    {{-- SIDE --}}
    <div class="col-md-4">
        <div class="card p-3">

            <h6 class="fw-bold">Details</h6>

            <p class="small mb-1"><b>File Type:</b> {{ $eResource->file_type ?? '—' }}</p>
            <p class="small mb-1"><b>ISBN:</b> {{ $eResource->isbn ?? '—' }}</p>

        </div>
    </div>

</div>

@endsection