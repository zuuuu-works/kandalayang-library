@extends('layouts.app')
@section('title', 'Recommend a Resource')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-star me-2"></i>Recommend a Resource</h4>
    <small class="text-muted">Suggest a resource to be added to the library</small>
</div>

<div class="card p-4" style="max-width:600px;">
    <form method="POST" action="{{ route('recommendations.store') }}">
        @csrf

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label fw-semibold">Resource Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="row g-3 mb-3">
            <div class="col">
                <label class="form-label fw-semibold">Author Name <span class="text-danger">*</span></label>
                <input type="text" name="author_name" class="form-control" value="{{ old('author_name') }}" required>
            </div>
            <div class="col">
                <label class="form-label fw-semibold">Publisher</label>
                <input type="text" name="publisher_name" class="form-control" value="{{ old('publisher_name') }}">
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col">
                <label class="form-label fw-semibold">Publication Year</label>
                <input type="number" name="publication_year" class="form-control"
                       value="{{ old('publication_year') }}" min="1900" max="{{ date('Y') }}">
            </div>
            <div class="col">
                <label class="form-label fw-semibold">File Type</label>
                <select name="file_type" class="form-select">
                    <option value="">-- Select --</option>
                    @foreach(['PDF','ePub','MP3','MP4','DOCX'] as $type)
                        <option value="{{ $type }}" {{ old('file_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Resource URL</label>
            <input type="url" name="resource_url" class="form-control"
                   value="{{ old('resource_url') }}" placeholder="https://...">
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Reason for Recommendation</label>
            <textarea name="reason" rows="3" class="form-control"
                      placeholder="Why should this resource be added to the library?">{{ old('reason') }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-send me-1"></i> Submit Recommendation
            </button>
            <a href="{{ route('recommendations.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection