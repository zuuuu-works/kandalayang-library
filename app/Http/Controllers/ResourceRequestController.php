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
            'publication_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y') + 1],
            'purpose'          => ['required', 'string'],
            'urgency'          => ['required', 'in:low,medium,high'],
        ]);

        $validated['user_id'] = Auth::id();

        ResourceRequest::create($validated);

        return redirect()->route('resource-requests.index')
            ->with('success', 'Resource request submitted successfully!');
    }

    /**
     * Librarian — view all resource requests.
     */
    public function adminIndex()
    {
        $requests = ResourceRequest::with('user')
            ->latest()->paginate(15);

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