@extends('layouts.app')
@section('title', 'Export Citation')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-quote me-2"></i>Export Citation</h4>
        <small class="text-muted">Copy the citation format you need</small>
    </div>
    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card p-4 mb-3" style="max-width:760px;">
    <h6 class="fw-bold text-muted small mb-1">RESOURCE</h6>
    <h5 class="fw-bold mb-1">{{ $eResource->title }}</h5>
    <p class="text-muted small mb-0">
        {{ $eResource->author->full_name }} · {{ $eResource->publisher->name }} · {{ $eResource->publication_year ?? 'n.d.' }}
    </p>
</div>

<div style="max-width:760px;">

    {{-- APA --}}
    <div class="card p-4 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="fw-bold mb-0"><span class="badge bg-primary me-2">APA</span> APA 7th Edition</h6>
            <button class="btn btn-sm btn-outline-secondary copy-btn" data-target="apa-citation">
                <i class="bi bi-clipboard me-1"></i> Copy
            </button>
        </div>
        <div id="apa-citation" class="bg-light rounded p-3 font-monospace small">
            {{ $citations['apa'] }}
        </div>
    </div>

    {{-- MLA --}}
    <div class="card p-4 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="fw-bold mb-0"><span class="badge bg-success me-2">MLA</span> MLA 9th Edition</h6>
            <button class="btn btn-sm btn-outline-secondary copy-btn" data-target="mla-citation">
                <i class="bi bi-clipboard me-1"></i> Copy
            </button>
        </div>
        <div id="mla-citation" class="bg-light rounded p-3 font-monospace small">
            {{ $citations['mla'] }}
        </div>
    </div>

    {{-- Chicago --}}
    <div class="card p-4 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="fw-bold mb-0"><span class="badge bg-warning text-dark me-2">CHI</span> Chicago Style</h6>
            <button class="btn btn-sm btn-outline-secondary copy-btn" data-target="chicago-citation">
                <i class="bi bi-clipboard me-1"></i> Copy
            </button>
        </div>
        <div id="chicago-citation" class="bg-light rounded p-3 font-monospace small">
            {{ $citations['chicago'] }}
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.copy-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var targetId  = this.getAttribute('data-target');
            var text      = document.getElementById(targetId).innerText;
            navigator.clipboard.writeText(text).then(() => {
                btn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Copied!';
                btn.classList.replace('btn-outline-secondary', 'btn-success');
                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-clipboard me-1"></i> Copy';
                    btn.classList.replace('btn-success', 'btn-outline-secondary');
                }, 2000);
            });
        });
    });
</script>
@endpush