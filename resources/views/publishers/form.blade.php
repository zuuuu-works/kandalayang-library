@extends('layouts.app')
@section('title', isset($publisher) ? 'Edit Publisher' : 'Add Publisher')

@section('content')
<div class="page-header">
    <h4>
        <i class="bi bi-{{ isset($publisher) ? 'pencil' : 'building' }} me-2"></i>
        {{ isset($publisher) ? 'Edit Publisher' : 'Add New Publisher' }}
    </h4>
</div>

<div class="card p-4" style="max-width: 560px;">
    <form method="POST"
          action="{{ isset($publisher) ? route('publishers.update', $publisher) : route('publishers.store') }}">
        @csrf
        @if(isset($publisher)) @method('PUT') @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label fw-semibold">Publisher Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $publisher->name ?? '') }}"
                   placeholder="e.g. Ateneo de Manila University Press" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $publisher->email ?? '') }}"
                       placeholder="publisher@example.com">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Website</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-globe"></i></span>
                <input type="url" name="website" class="form-control @error('website') is-invalid @enderror"
                       value="{{ old('website', $publisher->website ?? '') }}"
                       placeholder="https://example.com">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Address</label>
            <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror"
                      placeholder="Publisher's address...">{{ old('address', $publisher->address ?? '') }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-1"></i>
                {{ isset($publisher) ? 'Update Publisher' : 'Save Publisher' }}
            </button>
            <a href="{{ route('publishers.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection