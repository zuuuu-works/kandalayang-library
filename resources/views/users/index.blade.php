@extends('layouts.app')
@section('title', 'Manage Users')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-people me-2"></i>Users</h4>
    <small class="text-muted">Manage registered system users</small>
</div>

{{-- Filters --}}
<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('users.index') }}" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by name or email..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                @foreach(['librarian','student','faculty','researcher'] as $role)
                    <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">Search</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Registered</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-muted small">{{ $user->id }}</td>
                    <td class="fw-semibold">{{ $user->full_name }}</td>
                    <td class="small text-muted">{{ $user->email }}</td>
                    <td>
                        <span class="badge rounded-pill
                            bg-{{ $user->role === 'librarian' ? 'dark' : ($user->role === 'faculty' ? 'info text-dark' : ($user->role === 'researcher' ? 'warning text-dark' : 'secondary')) }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-secondary" title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($user->status === 'active')
                            <form method="POST" action="{{ route('users.deactivate', $user) }}" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-danger" title="Deactivate">
                                    <i class="bi bi-person-x"></i>
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('users.activate', $user) }}" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-success" title="Activate">
                                    <i class="bi bi-person-check"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer">{{ $users->links() }}</div>
    @endif
</div>
@endsection