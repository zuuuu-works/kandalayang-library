@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-pencil me-2"></i>Edit User</h4>
        <small class="text-muted">Updating profile of {{ $user->full_name }}</small>
    </div>
    <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card p-4" style="max-width: 560px;">
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

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
                <input type="text" name="first_name"
                       class="form-control @error('first_name') is-invalid @enderror"
                       value="{{ old('first_name', $user->first_name) }}" required>
            </div>
            <div class="col">
                <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                <input type="text" name="last_name"
                       class="form-control @error('last_name') is-invalid @enderror"
                       value="{{ old('last_name', $user->last_name) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="librarian"  {{ old('role', $user->role) === 'librarian'  ? 'selected' : '' }}>Librarian</option>
                <option value="student"    {{ old('role', $user->role) === 'student'    ? 'selected' : '' }}>Student</option>
                <option value="faculty"    {{ old('role', $user->role) === 'faculty'    ? 'selected' : '' }}>Faculty / Teacher</option>
                <option value="researcher" {{ old('role', $user->role) === 'researcher' ? 'selected' : '' }}>Researcher</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="active"   {{ old('status', $user->status) === 'active'   ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-1"></i> Update User
            </button>
            <a href="{{ route('users.show', $user) }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection