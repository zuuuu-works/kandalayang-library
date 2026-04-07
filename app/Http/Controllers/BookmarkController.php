<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\EResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Show all bookmarks of the logged-in user.
     */
    public function index()
    {
        $bookmarks = Bookmark::with(['eResource.category', 'eResource.author', 'eResource.publisher'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('bookmarks.index', compact('bookmarks'));
    }

    /**
     * Toggle bookmark — add if not bookmarked, remove if already bookmarked.
     */
    public function toggle(EResource $eResource)
    {
        $user = Auth::user();

        $existing = Bookmark::where('user_id', $user->id)
            ->where('e_resource_id', $eResource->id)
            ->first();

        if ($existing) {
            // Remove bookmark
            $existing->delete();
            $message = 'Bookmark removed.';
            $bookmarked = false;
        } else {
            // Add bookmark
            Bookmark::create([
                'user_id'       => $user->id,
                'e_resource_id' => $eResource->id,
            ]);
            $message = 'Resource bookmarked successfully!';
            $bookmarked = true;
        }

        // If request is AJAX, return JSON
        if (request()->expectsJson()) {
            return response()->json([
                'bookmarked' => $bookmarked,
                'message'    => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Remove a bookmark directly.
     */
    public function destroy(Bookmark $bookmark)
    {
        // Make sure user can only delete their own bookmarks
        if ($bookmark->user_id !== Auth::id()) {
            abort(403);
        }

        $bookmark->delete();

        return back()->with('success', 'Bookmark removed.');
    }
}