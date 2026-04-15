@extends('layouts.app')
@section('title', 'Request a Resource')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-envelope-plus me-2"></i>Request a Resource</h4>
    <small class="text-muted">Can't find what you need? Let the librarian know.</small>
</div>

<div class="card p-4" style="max-width:600px;">
    <form method="POST" action="{{ route('resource-requests.store') }}">
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
                <label class="form-label fw-semibold">Author Name</label>
                <input type="text" name="author_name" class="form-control" value="{{ old('author_name') }}">
            </div>
            <div class="col">
                <label class="form-label fw-semibold">ISBN</label>
                <input type="text" name="isbn" class="form-control" value="{{ old('isbn') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Publication Year</label>
            <input type="number" name="publication_year" class="form-control"
                   value="{{ old('publication_year') }}" min="1900" max="{{ date('Y') + 1 }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Purpose / Why do you need this? <span class="text-danger">*</span></label>
            <textarea name="purpose" rows="3" class="form-control" required
                      placeholder="Explain why you need this resource for your research...">{{ old('purpose') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Urgency <span class="text-danger">*</span></label>
            <select name="urgency" class="form-select" required>
                <option value="low"    {{ old('urgency') === 'low'    ? 'selected' : '' }}>🟢 Low — Anytime is fine</option>
                <option value="medium" {{ old('urgency') === 'medium' ? 'selected' : '' }} selected>🟡 Medium — Needed soon</option>
                <option value="high"   {{ old('urgency') === 'high'   ? 'selected' : '' }}>🔴 High — Urgently needed</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-send me-1"></i> Submit Request
            </button>
            <a href="{{ route('resource-requests.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection