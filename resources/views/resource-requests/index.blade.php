@extends('layouts.app')
@section('title', 'My Resource Requests')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-envelope-plus me-2"></i>My Resource Requests</h4>
        <small class="text-muted">Track the status of your submitted resource requests.</small>
    </div>
    <a href="{{ route('resource-requests.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> New Request
    </a>
</div>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Status Legend --}}
<div class="d-flex gap-2 mb-3 flex-wrap">
    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass me-1"></i>Pending</span>
    <span class="badge bg-info text-dark"><i class="bi bi-arrow-repeat me-1"></i>Processing</span>
    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Fulfilled</span>
    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Declined</span>
    <span class="text-muted small ms-1 align-self-center">— status legend</span>
</div>

@if($requests->isEmpty())
    <div class="card p-5 text-center text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
        <h6>No requests submitted yet.</h6>
        <p class="small mb-3">If you can't find a resource in the library, request it here.</p>
        <div>
            <a href="{{ route('resource-requests.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Submit Your First Request
            </a>
        </div>
    </div>
@else
    <div class="card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Year</th>
                        <th>Urgency</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $req)
                    <tr>
                        <td>
                            <div class="fw-semibold small">{{ $req->title }}</div>
                            @if($req->purpose)
                                <div class="text-muted" style="font-size:0.72rem;">
                                    {{ Str::limit($req->purpose, 60) }}
                                </div>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $req->author_name ?? '—' }}</td>
                        <td class="small text-muted">{{ $req->isbn ?? '—' }}</td>
                        <td class="small text-muted">{{ $req->publication_year ?? '—' }}</td>
                        <td>
                            @php
                                $urgencyClass = match($req->urgency) {
                                    'high'   => 'danger',
                                    'medium' => 'warning text-dark',
                                    default  => 'secondary',
                                };
                                $urgencyIcon = match($req->urgency) {
                                    'high'   => '🔴',
                                    'medium' => '🟡',
                                    default  => '🟢',
                                };
                            @endphp
                            <span class="badge bg-{{ $urgencyClass }}">
                                {{ $urgencyIcon }} {{ ucfirst($req->urgency) }}
                            </span>
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
                            @if($req->librarian_note)
                                <i class="bi bi-chat-left-text text-muted ms-1"
                                   title="{{ $req->librarian_note }}"
                                   data-bs-toggle="tooltip"
                                   style="cursor:pointer; font-size:0.8rem;"></i>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $req->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            {{-- Only allow cancel if still pending --}}
                            @if(in_array($req->status, ['pending', null]))
                                <form action="{{ route('resource-requests.destroy', $req) }}"
                                      method="POST"
                                      onsubmit="return confirm('Cancel this request?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Cancel Request">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                    </tr>

                    {{-- Librarian Note Row --}}
                    @if($req->librarian_note)
                    <tr class="table-light">
                        <td colspan="8" class="small text-muted ps-4">
                            <i class="bi bi-chat-left-quote me-1 text-primary"></i>
                            <strong>Librarian note:</strong> {{ $req->librarian_note }}
                        </td>
                    </tr>
                    @endif
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

@push('scripts')
<script>
    // Bootstrap tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
        .forEach(el => new bootstrap.Tooltip(el));
</script>
@endpush