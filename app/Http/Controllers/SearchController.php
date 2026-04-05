<?php

namespace App\Http\Controllers;

use App\Models\EResource;
use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    /**
     * Search and browse e-resources. (All roles)
     */
    public function index(Request $request)
    {
        $query = EResource::with(['category', 'author', 'publisher']);

        // Search by keyword
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('isbn', 'like', "%{$keyword}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by file type
        if ($request->filled('file_type')) {
            $query->where('file_type', $request->file_type);
        }

        $eResources = $query->latest()->paginate(12)->withQueryString();

        $categories = \App\Models\Category::all();

        return view('search.index', compact('eResources', 'categories'));
    }

    /**
     * Access (view/download) an e-resource and log it.
     */
    public function access(Request $request, EResource $eResource)
    {
        $validated = $request->validate([
            'access_type' => ['required', 'in:view,download,stream'],
        ]);

        // Business Rule #10: Every access must be recorded in Access_Log
        AccessLog::create([
            'user_id'      => Auth::id(),
            'e_resource_id' => $eResource->id,
            'accessed_at'  => now(),
            'access_type'  => $validated['access_type'],
        ]);

        return redirect()->away($eResource->file_url);
    }
}