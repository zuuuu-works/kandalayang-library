<?php

namespace App\Http\Controllers;

use App\Models\ResourceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceRequestController extends Controller
{
    /**
     * Researcher — view their own requests.
     */
    public function index()
    {
        $requests = ResourceRequest::where('user_id', Auth::id())
            ->latest()->paginate(10);

        return view('resource-requests.index', compact('requests'));
    }

    /**
     * Researcher — show form to request a resource.
     */
    public function create()
    {
        return view('resource-requests.create');
    }

    /**
     * Researcher — submit a resource request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'author_name'      => ['nullable', 'string', 'max:255'],
            'isbn'             => ['nullable', 'string', 'max:50'],
            'publication_year' => ['nullable', 'integer', 'min:1000', 'max:' . date('Y') + 1],
            'purpose'          => ['required', 'string'],
            'urgency'          => ['required', 'in:low,medium,high'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'pending';

        ResourceRequest::create($validated);

        return redirect()->route('resource-requests.index')
            ->with('success', 'Resource request submitted successfully!');
    }

    /**
     * Researcher — cancel a pending request.
     */
    public function destroy(ResourceRequest $resourceRequest)
    {
        // Only the owner can cancel, and only if still pending
        abort_if(
            $resourceRequest->user_id !== Auth::id() || $resourceRequest->status !== 'pending',
            403
        );

        $resourceRequest->delete();

        return back()->with('success', 'Request cancelled successfully.');
    }

    /**
     * Librarian — view all resource requests with filters.
     */
    public function adminIndex(Request $request)
    {
        $query = ResourceRequest::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('urgency')) {
            $query->where('urgency', $request->urgency);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('full_name', 'like', "%{$search}%"));
            });
        }

        $requests = $query->paginate(15)->withQueryString();

        return view('resource-requests.admin', compact('requests'));
    }

    /**
     * Librarian — update status of a request.
     */
    public function updateStatus(Request $request, ResourceRequest $resourceRequest)
    {
        $validated = $request->validate([
            'status'         => ['required', 'in:processing,fulfilled,declined'],
            'librarian_note' => ['nullable', 'string'],
        ]);

        $resourceRequest->update($validated);

        return back()->with('success', 'Request status updated.');
    }
}