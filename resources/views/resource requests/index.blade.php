@extends('layouts.app')
@section('title', 'My Resource Requests')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-envelope-plus me-2"></i>My Resource Requests</h4>
        <small class="text-muted">Resources you have requested from the library</small>
    </div>
    <a href="{{ route('resource-requests.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> New Request
    </a>
</div>

@if($requests->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-envelope fs-1 d-block mb-3"></i>
        <h5>No requests yet</h5>
        <p class="small">Can't find a resource? Request it from the librarian!</p>
        <a href="{{ route('resource-requests.create') }}" class="btn btn-primary mt-2">Request Now</a>
    </div>
@else
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Urgency</th>
                    <th>Status</th>
                    <th>Librarian Note</th>
                    <th>Requested</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                <tr>
                    <td>
                        <div class="fw-semibold small">{{ $req->title }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">{{ Str::limit($req->purpose, 60) }}</div>
                    </td>
                    <td>
                        <span class="badge bg-{{ $req->urgency === 'high' ? 'danger' : ($req->urgency === 'medium' ? 'warning text-dark' : 'secondary') }}">
                            {{ ucfirst($req->urgency) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $req->status === 'fulfilled' ? 'success' : ($req->status === 'declined' ? 'danger' : ($req->status === 'processing' ? 'info text-dark' : 'warning text-dark')) }}">
                            {{ ucfirst($req->status) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $req->librarian_note ?? '—' }}</td>
                    <td class="small text-muted">{{ $req->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($requests->hasPages())
    <div class="card-footer">{{ $requests->links() }}</div>
    @endif
</div>
@endif
@endsection