@extends('layouts.app')
@section('title', 'Resource Requests — Admin')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-envelope-plus me-2"></i>Resource Requests</h4>
        <small class="text-muted">Review and update the status of researcher resource requests.</small>
    </div>
    {{-- Summary badges --}}
    <div class="d-flex gap-2">
        <span class="badge bg-warning text-dark fs-6">
            {{ $requests->where('status', 'pending')->count() }} Pending
        </span>
        <span class="badge bg-info text-dark fs-6">
            {{ $requests->where('status', 'processing')->count() }} Processing
        </span>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Filter Bar --}}
<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('resource-requests.admin') }}" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label small fw-semibold mb-1">Status</label>
            <select name="status" class="form-select form-select-sm">
                <option value="">All Statuses</option>
                <option value="pending"    {{ request('status') === 'pending'    ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="fulfilled"  {{ request('status') === 'fulfilled'  ? 'selected' : '' }}>Fulfilled</option>
                <option value="declined"   {{ request('status') === 'declined'   ? 'selected' : '' }}>Declined</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold mb-1">Urgency</label>
            <select name="urgency" class="form-select form-select-sm">
                <option value="">All Urgencies</option>
                <option value="high"   {{ request('urgency') === 'high'   ? 'selected' : '' }}>🔴 High</option>
                <option value="medium" {{ request('urgency') === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                <option value="low"    {{ request('urgency') === 'low'    ? 'selected' : '' }}>🟢 Low</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label small fw-semibold mb-1">Search</label>
            <input type="text" name="search" class="form-control form-control-sm"
                   placeholder="Title, author, or requester name…"
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-2 d-flex gap-1">
            <button type="submit" class="btn btn-primary btn-sm w-100">
                <i class="bi bi-funnel me-1"></i> Filter
            </button>
            <a href="{{ route('resource-requests.admin') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-x"></i>
            </a>
        </div>
    </form>
</div>

@if($requests->isEmpty())
    <div class="card p-5 text-center text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
        <h6>No resource requests found.</h6>
    </div>
@else
    <div class="card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Requested By</th>
                        <th>Title</th>
                        <th>Author / ISBN</th>
                        <th>Urgency</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $req)
                    <tr>
                        <td class="text-muted small">{{ $req->id }}</td>
                        <td>
                            <div class="small fw-semibold">{{ $req->user->full_name }}</div>
                            <div class="text-muted" style="font-size:0.72rem;">{{ $req->user->email }}</div>
                        </td>
                        <td>
                            <div class="small fw-semibold">{{ $req->title }}</div>
                            @if($req->publication_year)
                                <div class="text-muted" style="font-size:0.72rem;">{{ $req->publication_year }}</div>
                            @endif
                        </td>
                        <td class="small text-muted">
                            {{ $req->author_name ?? '—' }}
                            @if($req->isbn)
                                <br><span class="badge bg-light text-dark border">{{ $req->isbn }}</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $urgencyClass = match($req->urgency) {
                                    'high'   => 'danger',
                                    'medium' => 'warning text-dark',
                                    default  => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $urgencyClass }}">{{ ucfirst($req->urgency) }}</span>
                        </td>
                        <td>
                            @php
                                $statusClass = match($req->status) {
                                    'fulfilled'  => 'success',
                                    'declined'   => 'danger',
                                    'processing' => 'info text-dark',
                                    default      => 'warning text-dark',
                                };
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">
                                {{ ucfirst($req->status ?? 'pending') }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $req->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-{{ $req->id }}">
                                <i class="bi bi-pencil-square me-1"></i> Update
                            </button>
                        </td>
                    </tr>

                    {{-- Purpose row --}}
                    @if($req->purpose)
                    <tr class="table-light">
                        <td colspan="8" class="small text-muted ps-4 py-1">
                            <i class="bi bi-chat-left-text me-1 text-primary"></i>
                            <strong>Purpose:</strong> {{ $req->purpose }}
                            @if($req->librarian_note)
                                &nbsp;·&nbsp;
                                <i class="bi bi-reply me-1 text-success"></i>
                                <strong>Your note:</strong> {{ $req->librarian_note }}
                            @endif
                        </td>
                    </tr>
                    @endif

                    {{-- ── Status Update Modal ──────────────────────────── --}}
                    <div class="modal fade" id="modal-{{ $req->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">
                                        <i class="bi bi-pencil-square me-2 text-primary"></i>
                                        Update Request — <em>{{ Str::limit($req->title, 40) }}</em>
                                    </h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('resource-requests.status', $req) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-body">

                                        {{-- Request summary --}}
                                        <div class="alert alert-light border mb-3 small">
                                            <div><strong>Requested by:</strong> {{ $req->user->full_name }}</div>
                                            @if($req->author_name)
                                            <div><strong>Author:</strong> {{ $req->author_name }}</div>
                                            @endif
                                            @if($req->isbn)
                                            <div><strong>ISBN:</strong> {{ $req->isbn }}</div>
                                            @endif
                                            @if($req->purpose)
                                            <div class="mt-1"><strong>Purpose:</strong> {{ $req->purpose }}</div>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">New Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-select" required>
                                                <option value="processing" {{ $req->status === 'processing' ? 'selected' : '' }}>
                                                    ⏳ Processing
                                                </option>
                                                <option value="fulfilled" {{ $req->status === 'fulfilled' ? 'selected' : '' }}>
                                                    ✅ Fulfilled
                                                </option>
                                                <option value="declined" {{ $req->status === 'declined' ? 'selected' : '' }}>
                                                    ❌ Declined
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-1">
                                            <label class="form-label fw-semibold">
                                                Note to Researcher
                                                <span class="text-muted fw-normal">(optional)</span>
                                            </label>
                                            <textarea name="librarian_note"
                                                      rows="3"
                                                      class="form-control"
                                                      placeholder="e.g. We have ordered this resource and it will be available soon…">{{ $req->librarian_note }}</textarea>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                                data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-check-circle me-1"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- ── End Modal ────────────────────────────────────── --}}

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $requests->links() }}
    </div>
@endif

@endsection