@extends('layouts.app')
@section('title', isset($eResource) ? 'Edit E-Resource' : 'Add E-Resource')

@section('content')

<style>
.required-star {
    color: #dc3545;
    margin-left: 3px;
}
</style>

<div class="container py-0">

    <div class="card shadow-sm border-0">

        {{-- HEADER --}}
        <div class="card-header bg-white">
            <h5 class="mb-0">
                {{ isset($eResource) ? 'Edit E-Resource' : 'Add New E-Resource' }}
            </h5>
            <small class="text-muted">Manage your library digital resources</small>
        </div>

        <div class="card-body">

            <form method="POST"
                  action="{{ isset($eResource) ? route('e-resources.update', $eResource) : route('e-resources.store') }}"
                  enctype="multipart/form-data">

                @csrf
                @if(isset($eResource)) @method('PUT') @endif

                <div class="row g-3">

                    {{-- TITLE --}}
                    <div class="col-12">
                        <label class="form-label">Title <span class="required-star">*</span></label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $eResource->title ?? '') }}"
                               placeholder="Enter resource title">
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="col-12">
                        <label class="form-label">Description <span class="required-star">*</span></label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Enter description">{{ old('description', $eResource->description ?? '') }}</textarea>
                    </div>

                    {{-- CATEGORY --}}
                    <div class="col-md-4">
                        <label class="form-label">Category <span class="required-star">*</span></label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $eResource->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- AUTHOR --}}
                    <div class="col-md-4">
                        <label class="form-label">Author</label>
                        <select name="author_id" class="form-select">
                            <option value="">Select Author</option>
                            @foreach($authors as $a)
                                <option value="{{ $a->id }}"
                                    {{ old('author_id', $eResource->author_id ?? '') == $a->id ? 'selected' : '' }}>
                                    {{ $a->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- PUBLISHER --}}
                    <div class="col-md-4">
                        <label class="form-label">Publisher <span class="required-star">*</span></label>
                        <select name="publisher_id" class="form-select">
                            <option value="">Select Publisher</option>
                            @foreach($publishers as $p)
                                <option value="{{ $p->id }}"
                                    {{ old('publisher_id', $eResource->publisher_id ?? '') == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- YEAR --}}
                    <div class="col-md-6">
                        <label class="form-label">Publication Year <span class="required-star">*</span></label>
                        <input type="number"
                               name="publication_year"
                               class="form-control"
                               value="{{ old('publication_year', $eResource->publication_year ?? '') }}"
                               min="1900"
                               max="{{ date('Y') }}"
                               placeholder="e.g. 2024">
                    </div>

                    {{-- ISBN --}}
                    <div class="col-md-6">
                        <label class="form-label">ISBN</label>
                        <input type="text"
                               name="isbn"
                               class="form-control"
                               value="{{ old('isbn', $eResource->isbn ?? '') }}"
                               placeholder="e.g. 978-3-16-148410-0">
                    </div>

                    {{-- FILE UPLOAD --}}
                    <div class="col-md-6">
                        <label class="form-label">Upload File</label>
                        <input type="file"
                               name="file_upload"
                               id="file_upload"
                               class="form-control"
                               accept=".pdf,.epub,.mp3,.mp4,.docx">
                    </div>

                    {{-- URL --}}
                    <div class="col-md-6">
                        <label class="form-label">External URL</label>
                        <input type="url"
                               name="file_url"
                               id="file_url"
                               class="form-control"
                               value="{{ old('file_url', $eResource->file_url ?? '') }}"
                               placeholder="https://drive.google.com/...">
                    </div>

                    {{-- WARNING --}}
                    <div class="col-12">
                        <div class="alert alert-warning py-2 small mb-0">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            You can only use <strong>File Upload OR External URL</strong>.
                            The system will automatically disable the other option.
                        </div>
                    </div>

                    {{-- RECOMMENDATION --}}
                    <div class="col-12">
                        <div class="alert alert-info py-2 small mb-0">
                            <i class="bi bi-lightbulb me-1"></i>
                            <strong>Recommendation:</strong> Uploading a file is preferred for better accessibility and offline access.
                        </div>
                    </div>

                    {{-- SMART NOTICE --}}
                    <div class="col-12">
                        <div class="alert alert-secondary py-2 small mb-0">
                            <i class="bi bi-shield-check me-1"></i>
                            System ensures data consistency: only one source is allowed per resource.
                        </div>
                    </div>

                    {{-- ERRORS --}}
                    @if($errors->any())
                        <div class="col-12">
                            <div class="alert alert-danger mb-0">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- BUTTON --}}
                    <div class="col-12">
                        <button class="btn btn-primary w-100">
                            {{ isset($eResource) ? 'Update Resource' : 'Save Resource' }}
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

{{-- SMART TOGGLE JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const fileInput = document.getElementById('file_upload');
    const urlInput = document.getElementById('file_url');

    function updateState() {
        const hasFile = fileInput.files.length > 0;
        const hasUrl = urlInput.value.trim() !== '';

        if (hasFile) {
            urlInput.disabled = true;
        } 
        else if (hasUrl) {
            fileInput.disabled = true;
        } 
        else {
            fileInput.disabled = false;
            urlInput.disabled = false;
        }
    }

    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            urlInput.value = '';
        }
        updateState();
    });

    urlInput.addEventListener('input', function () {
        if (urlInput.value.trim() !== '') {
            fileInput.value = '';
        }
        updateState();
    });

});
</script>

@endsection