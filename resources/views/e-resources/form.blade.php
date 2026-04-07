@extends('layouts.app')
@section('title', isset($eResource) ? 'Edit E-Resource' : 'Add E-Resource')

@section('content')
<div class="page-header">
    <h4>
        <i class="bi bi-{{ isset($eResource) ? 'pencil' : 'plus-circle' }} me-2"></i>
        {{ isset($eResource) ? 'Edit E-Resource' : 'Add New E-Resource' }}
    </h4>
</div>

<div class="card p-4" style="max-width: 760px;">
    <form method="POST"
          action="{{ isset($eResource) ? route('e-resources.update', $eResource) : route('e-resources.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if(isset($eResource)) @method('PUT') @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $eResource->title ?? '') }}" required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" rows="3"
                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $eResource->description ?? '') }}</textarea>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">-- Select --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $eResource->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Author <span class="text-danger">*</span></label>
                <select name="author_id" class="form-select @error('author_id') is-invalid @enderror" required>
                    <option value="">-- Select --</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}"
                            {{ old('author_id', $eResource->author_id ?? '') == $author->id ? 'selected' : '' }}>
                            {{ $author->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Publisher <span class="text-danger">*</span></label>
                <select name="publisher_id" class="form-select @error('publisher_id') is-invalid @enderror" required>
                    <option value="">-- Select --</option>
                    @foreach($publishers as $pub)
                        <option value="{{ $pub->id }}"
                            {{ old('publisher_id', $eResource->publisher_id ?? '') == $pub->id ? 'selected' : '' }}>
                            {{ $pub->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">ISBN</label>
                <input type="text" name="isbn" class="form-control"
                       value="{{ old('isbn', $eResource->isbn ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Publication Year</label>
                <input type="number" name="publication_year" class="form-control"
                       value="{{ old('publication_year', $eResource->publication_year ?? '') }}"
                       min="1900" max="{{ date('Y') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">File Type</label>
                <select name="file_type" class="form-select">
                    <option value="">-- Select --</option>
                    @foreach(['PDF','ePub','MP3','MP4','DOCX'] as $type)
                        <option value="{{ $type }}"
                            {{ old('file_type', $eResource->file_type ?? '') === $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- File Upload Section --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Upload File <span class="text-muted small">(PDF, ePub, MP3, MP4, DOCX — max 50MB)</span></label>

            @if(isset($eResource) && $eResource->file_path)
                {{-- Show current uploaded file --}}
                <div class="alert alert-info py-2 mb-2 d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-file-earmark-check me-2"></i>Current file: <strong>{{ basename($eResource->file_path) }}</strong></span>
                    <a href="{{ route('file.access', ['eResource' => $eResource, 'type' => 'view']) }}"
                       target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye me-1"></i>Preview
                    </a>
                </div>
            @endif

            <input type="file" name="file_upload"
                   class="form-control @error('file_upload') is-invalid @enderror"
                   accept=".pdf,.epub,.mp3,.mp4,.docx">
            <div class="form-text">Upload a new file to replace the existing one.</div>
        </div>

        {{-- OR External URL --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">OR External URL <span class="text-muted small">(Google Drive, website link, etc.)</span></label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                <input type="url" name="file_url" class="form-control @error('file_url') is-invalid @enderror"
                       value="{{ old('file_url', $eResource->file_url ?? '') }}"
                       placeholder="https://drive.google.com/...">
            </div>
            <div class="form-text">Use this if the file is hosted externally. Leave blank if you uploaded a file above.</div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-1"></i>
                {{ isset($eResource) ? 'Update Resource' : 'Save Resource' }}
            </button>
            <a href="{{ route('e-resources.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection