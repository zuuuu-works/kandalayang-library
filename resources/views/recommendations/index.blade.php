@extends('layouts.app')
@section('title', 'My Recommendations')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-star me-2"></i>My Recommendations</h4>
        <small class="text-muted">Resources you have recommended to the library</small>
    </div>
    <a href="{{ route('recommendations.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Recommend a Resource
    </a>
</div>

@if($recommendations->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-star fs-1 d-block mb-3"></i>
        <h5>No recommendations yet</h5>
        <p class="small">Help improve the library by recommending resources!</p>
        <a href="{{ route('recommendations.create') }}" class="btn btn-primary mt-2">Recommend Now</a>
    </div>
@else
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                    <th>Status</th>
                    <th>Librarian Note</th>
                    <th>Submitted</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recommendations as $rec)
                <tr>
                    <td class="fw-semibold small">{{ $rec->title }}</td>
                    <td class="small text-muted">{{ $rec->author_name }}</td>
                    <td class="small text-muted">{{ $rec->publication_year ?? '—' }}</td>
                    <td>
                        <span class="badge bg-{{ $rec->status === 'approved' ? 'success' : ($rec->status === 'rejected' ? 'danger' : 'warning text-dark') }}">
                            {{ ucfirst($rec->status) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $rec->librarian_note ?? '—' }}</td>
                    <td class="small text-muted">{{ $rec->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($recommendations->hasPages())
    <div class="card-footer">{{ $recommendations->links() }}</div>
    @endif
</div>
@endif
@endsection