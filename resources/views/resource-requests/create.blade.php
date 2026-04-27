@extends('layouts.app')
@section('title', 'Request a Resource')

@section('content')

{{-- ── Page Header ──────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-0"><i class="bi bi-envelope-plus me-2"></i>Request a Resource</h5>
        <small class="text-muted">Can't find what you need? Let the librarian know.</small>
    </div>
    <a href="{{ route('resource-requests.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger rounded-3 small py-2 mb-3">
        <i class="bi bi-exclamation-triangle me-1"></i>
        @foreach($errors->all() as $error) {{ $error }}{{ !$loop->last ? ' · ' : '' }} @endforeach
    </div>
@endif

<div class="row g-3">

    {{-- ── Form ─────────────────────────────────────────────── --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('resource-requests.store') }}">
                    @csrf

                    {{-- Title --}}
                    <div class="mb-2">
                        <label class="form-label fw-semibold small mb-1">Resource Title <span class="text-danger">*</span></label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-book text-muted"></i></span>
                            <input type="text" name="title"
                                   class="form-control border-start-0 @error('title') is-invalid @enderror"
                                   placeholder="e.g. Introduction to Machine Learning"
                                   value="{{ old('title') }}" required>
                        </div>
                    </div>

                    {{-- Author + ISBN --}}
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label fw-semibold small mb-1">Author Name</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="author_name"
                                       class="form-control border-start-0"
                                       placeholder="e.g. John Doe"
                                       value="{{ old('author_name') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small mb-1">ISBN</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-upc text-muted"></i></span>
                                <input type="text" name="isbn"
                                       class="form-control border-start-0"
                                       placeholder="e.g. 978-3-16-148410-0"
                                       value="{{ old('isbn') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Publication Year --}}
                    <div class="mb-2">
                        <label class="form-label fw-semibold small mb-1">Publication Year</label>
                        <div class="input-group input-group-sm" style="max-width:180px;">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar3 text-muted"></i></span>
                            <input type="number" name="publication_year"
                                   class="form-control border-start-0"
                                   placeholder="{{ date('Y') }}"
                                   value="{{ old('publication_year') }}"
                                   min="1900" max="{{ date('Y') + 1 }}">
                        </div>
                    </div>

                    {{-- Purpose --}}
                    <div class="mb-2">
                        <label class="form-label fw-semibold small mb-1">Purpose / Why do you need this? <span class="text-danger">*</span></label>
                        <textarea name="purpose" rows="2"
                                  class="form-control form-control-sm @error('purpose') is-invalid @enderror"
                                  placeholder="Explain why you need this resource for your research..."
                                  required>{{ old('purpose') }}</textarea>
                    </div>

                    {{-- Urgency --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold small mb-1">Urgency Level <span class="text-danger">*</span></label>
                        <div class="d-flex gap-2 flex-wrap">
                            <input type="radio" class="btn-check" name="urgency" id="urgency-low"
                                   value="low" {{ old('urgency') === 'low' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success btn-sm" for="urgency-low">
                                <i class="bi bi-circle-fill me-1" style="font-size:0.45rem; vertical-align:middle;"></i>Low — Anytime
                            </label>

                            <input type="radio" class="btn-check" name="urgency" id="urgency-medium"
                                   value="medium" {{ old('urgency', 'medium') === 'medium' ? 'checked' : '' }}>
                            <label class="btn btn-outline-warning btn-sm" for="urgency-medium">
                                <i class="bi bi-circle-fill me-1" style="font-size:0.45rem; vertical-align:middle;"></i>Medium — Soon
                            </label>

                            <input type="radio" class="btn-check" name="urgency" id="urgency-high"
                                   value="high" {{ old('urgency') === 'high' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger btn-sm" for="urgency-high">
                                <i class="bi bi-circle-fill me-1" style="font-size:0.45rem; vertical-align:middle;"></i>High — Urgent
                            </label>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex gap-2 pt-2 border-top">
                        <button type="submit" class="btn btn-primary btn-sm px-4">
                            <i class="bi bi-send me-1"></i> Submit Request
                        </button>
                        <a href="{{ route('resource-requests.index') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- ── Side Panel ────────────────────────────────────────── --}}
    <div class="col-md-4 d-flex flex-column gap-3">

        <div class="card border-0 bg-light rounded-4 p-3">
            <h6 class="fw-bold small mb-2"><i class="bi bi-lightbulb text-warning me-2"></i>Tips for faster approval</h6>
            <ul class="small text-muted ps-3 mb-0" style="line-height:2;">
                <li>Include the exact title and author</li>
                <li>Add the ISBN if available</li>
                <li>Be specific about your purpose</li>
                <li>Set urgency accurately</li>
            </ul>
        </div>

        <div class="card border-0 rounded-4 p-3" style="background:#fff8e1;">
            <h6 class="fw-bold small mb-2"><i class="bi bi-clock-history text-warning me-2"></i>What happens next?</h6>
            <p class="small text-muted mb-2" style="line-height:1.7;">
                The librarian will review your request and update its status.
                Track it under <strong>My Requests</strong>.
            </p>
            <div class="d-flex gap-1 flex-wrap">
                <span class="badge bg-warning text-dark">Pending</span>
                <i class="bi bi-arrow-right small text-muted align-self-center"></i>
                <span class="badge bg-info text-dark">Processing</span>
                <i class="bi bi-arrow-right small text-muted align-self-center"></i>
                <span class="badge bg-success">Fulfilled</span>
            </div>
        </div>

    </div>

</div>

@endsection