@extends('layouts.app')
@section('title', 'Export Citation')

@section('content')

{{-- ── Page Header ──────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0 fw-bold"><i class="bi bi-quote me-2"></i>Export Citation</h5>
        <small class="text-muted">Copy the citation format you need</small>
    </div>
    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

{{-- ── Resource Info ─────────────────────────────────────────── --}}
<div class="card border-0 text-white mb-3" style="background: linear-gradient(135deg, #1e3a5f, #2d6a9f);">
    <div class="card-body py-3 px-4">
        <p class="text-uppercase fw-bold mb-1" style="font-size:0.65rem; letter-spacing:0.1em; opacity:0.6;">
            <i class="bi bi-journals me-1"></i>Resource
        </p>
        <h6 class="fw-bold mb-1">{{ $eResource->title }}</h6>
        <div class="d-flex flex-wrap gap-3 small" style="opacity:0.75;">
            <span><i class="bi bi-person me-1"></i>{{ $eResource->author->full_name }}</span>
            <span><i class="bi bi-building me-1"></i>{{ $eResource->publisher->name }}</span>
            <span><i class="bi bi-calendar3 me-1"></i>{{ $eResource->publication_year ?? 'n.d.' }}</span>
        </div>
    </div>
</div>

{{-- ── Citation Cards Row ────────────────────────────────────── --}}
<div class="row g-3">

    {{-- APA --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-top: 3px solid #0d6efd !important;">
            <div class="card-header bg-white d-flex align-items-center gap-2 py-2 px-3 border-bottom">
                <div class="bg-primary bg-opacity-10 text-primary rounded-2 d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                     style="width:36px; height:36px; font-size:0.7rem;">APA</div>
                <div>
                    <div class="fw-semibold small">APA 7th Edition</div>
                    <div class="text-muted" style="font-size:0.68rem;">Am. Psychological Assoc.</div>
                </div>
            </div>
            <div class="card-body p-3 d-flex flex-column">
                <div id="apa-citation" class="bg-light rounded-2 p-2 small text-secondary lh-lg flex-grow-1" style="font-size:0.78rem;">
                    {{ $citations['apa'] }}
                </div>
                <button class="btn btn-sm btn-outline-primary w-100 mt-2 copy-btn" data-target="apa-citation">
                    <i class="bi bi-clipboard me-1"></i>Copy APA
                </button>
            </div>
        </div>
    </div>

    {{-- MLA --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-top: 3px solid #198754 !important;">
            <div class="card-header bg-white d-flex align-items-center gap-2 py-2 px-3 border-bottom">
                <div class="bg-success bg-opacity-10 text-success rounded-2 d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                     style="width:36px; height:36px; font-size:0.7rem;">MLA</div>
                <div>
                    <div class="fw-semibold small">MLA 9th Edition</div>
                    <div class="text-muted" style="font-size:0.68rem;">Modern Language Assoc.</div>
                </div>
            </div>
            <div class="card-body p-3 d-flex flex-column">
                <div id="mla-citation" class="bg-light rounded-2 p-2 small text-secondary lh-lg flex-grow-1" style="font-size:0.78rem;">
                    {{ $citations['mla'] }}
                </div>
                <button class="btn btn-sm btn-outline-success w-100 mt-2 copy-btn" data-target="mla-citation">
                    <i class="bi bi-clipboard me-1"></i>Copy MLA
                </button>
            </div>
        </div>
    </div>

    {{-- Chicago --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-top: 3px solid #ffc107 !important;">
            <div class="card-header bg-white d-flex align-items-center gap-2 py-2 px-3 border-bottom">
                <div class="bg-warning bg-opacity-10 text-warning rounded-2 d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                     style="width:36px; height:36px; font-size:0.7rem;">CHI</div>
                <div>
                    <div class="fw-semibold small">Chicago Style</div>
                    <div class="text-muted" style="font-size:0.68rem;">Notes-Bibliography System</div>
                </div>
            </div>
            <div class="card-body p-3 d-flex flex-column">
                <div id="chicago-citation" class="bg-light rounded-2 p-2 small text-secondary lh-lg flex-grow-1" style="font-size:0.78rem;">
                    {{ $citations['chicago'] }}
                </div>
                <button class="btn btn-sm btn-outline-warning w-100 mt-2 copy-btn" data-target="chicago-citation">
                    <i class="bi bi-clipboard me-1"></i>Copy Chicago
                </button>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.copy-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var text     = document.getElementById(targetId).innerText.trim();
            navigator.clipboard.writeText(text).then(() => {
                var original = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Copied!';
                btn.classList.add('active');
                setTimeout(() => {
                    btn.innerHTML = original;
                    btn.classList.remove('active');
                }, 2000);
            });
        });
    });
</script>
@endpush