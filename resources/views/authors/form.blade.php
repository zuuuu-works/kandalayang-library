@extends('layouts.app')
@section('title', isset($author) ? 'Edit Author' : 'Add Author')

@section('content')
<div class="page-header">
    <h4>
        <i class="bi bi-{{ isset($author) ? 'pencil' : 'person-plus' }} me-2"></i>
        {{ isset($author) ? 'Edit Author' : 'Add New Author' }}
    </h4>
</div>

<div class="card p-4" style="max-width: 560px;">
    <form method="POST"
          action="{{ isset($author) ? route('authors.update', $author) : route('authors.store') }}">
        @csrf
        @if(isset($author)) @method('PUT') @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-3 mb-3">
            <div class="col">
                <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                       value="{{ old('first_name', $author->first_name ?? '') }}"
                       placeholder="Juan" required>
            </div>
            <div class="col">
                <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                       value="{{ old('last_name', $author->last_name ?? '') }}"
                       placeholder="Dela Cruz" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $author->email ?? '') }}"
                       placeholder="author@example.com">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Bio</label>
            <textarea name="bio" rows="3" class="form-control @error('bio') is-invalid @enderror"
                      placeholder="Short biography of the author...">{{ old('bio', $author->bio ?? '') }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-1"></i>
                {{ isset($author) ? 'Update Author' : 'Save Author' }}
            </button>
            <a href="{{ route('authors.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection