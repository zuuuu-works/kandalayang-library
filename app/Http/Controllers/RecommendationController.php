<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    /**
     * Faculty — view their own recommendations.
     */
    public function index()
    {
        $recommendations = Recommendation::where('user_id', Auth::id())
            ->latest()->paginate(10);

        return view('recommendations.index', compact('recommendations'));
    }

    /**
     * Faculty — show form to recommend a resource.
     */
    public function create()
    {
        return view('recommendations.create');
    }

    /**
     * Faculty — submit a recommendation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'author_name'      => ['required', 'string', 'max:255'],
            'publisher_name'   => ['nullable', 'string', 'max:255'],
            'publication_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'file_type'        => ['nullable', 'string'],
            'reason'           => ['nullable', 'string'],
            'resource_url'     => ['nullable', 'url'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'pending';

        Recommendation::create($validated);

        return redirect()->route('recommendations.index')
            ->with('success', 'Resource recommendation submitted successfully!');
    }

    /**
     * Librarian — view all recommendations.
     */
    public function adminIndex()
    {
        $recommendations = Recommendation::with('user')
            ->latest()->paginate(15);

        return view('recommendations.admin', compact('recommendations'));
    }

    /**
     * Librarian — approve or reject a recommendation.
     */
    public function updateStatus(Request $request, Recommendation $recommendation)
    {
        $validated = $request->validate([
            'status'        => ['required', 'in:approved,rejected'],
            'librarian_note'=> ['nullable', 'string'],
        ]);

        $recommendation->update($validated);

        return back()->with('success', 'Recommendation status updated.');
    }
}