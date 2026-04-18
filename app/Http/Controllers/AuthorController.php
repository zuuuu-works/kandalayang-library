<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('eResources')->latest()->paginate(10);
        return view('authors.index', compact('authors'));
    }

    public function archived()
    {
        $authors = Author::onlyTrashed()->latest('deleted_at')->paginate(10);
        return view('authors.archived', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['nullable', 'email', 'unique:authors,email'],
            'bio'        => ['nullable', 'string'],
        ]);

        Author::create($validated);

        return redirect()->route('authors.index')
            ->with('success', 'Author added successfully.');
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['nullable', 'email', 'unique:authors,email,' . $author->id],
            'bio'        => ['nullable', 'string'],
        ]);

        $author->update($validated);

        return redirect()->route('authors.index')
            ->with('success', 'Author updated successfully.');
    }

    /**
     * Soft delete — archive the author.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')
            ->with('success', 'Author archived. Can be restored anytime.');
    }

    /**
     * Restore an archived author.
     */
    public function restore(int $id)
    {
        $author = Author::onlyTrashed()->findOrFail($id);
        $author->restore();

        return redirect()->route('authors.archived')
            ->with('success', "{$author->full_name} has been restored.");
    }

    /**
     * Permanently delete an archived author.
     */
    public function forceDelete(int $id)
    {
        $author = Author::onlyTrashed()->findOrFail($id);
        $author->forceDelete();

        return redirect()->route('authors.archived')
            ->with('success', 'Author permanently deleted.');
    }
}