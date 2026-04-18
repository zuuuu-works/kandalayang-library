<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::withCount('eResources')->latest()->paginate(10);
        return view('publishers.index', compact('publishers'));
    }

    public function archived()
    {
        $publishers = Publisher::onlyTrashed()->latest('deleted_at')->paginate(10);
        return view('publishers.archived', compact('publishers'));
    }

    public function create()
    {
        return view('publishers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'unique:publishers,email'],
            'website' => ['nullable', 'url'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        Publisher::create($validated);

        return redirect()->route('publishers.index')
            ->with('success', 'Publisher added successfully.');
    }

    public function edit(Publisher $publisher)
    {
        return view('publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'unique:publishers,email,' . $publisher->id],
            'website' => ['nullable', 'url'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $publisher->update($validated);

        return redirect()->route('publishers.index')
            ->with('success', 'Publisher updated successfully.');
    }

    /**
     * Soft delete — archive the publisher.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()->route('publishers.index')
            ->with('success', 'Publisher archived. Can be restored anytime.');
    }

    /**
     * Restore an archived publisher.
     */
    public function restore(int $id)
    {
        $publisher = Publisher::onlyTrashed()->findOrFail($id);
        $publisher->restore();

        return redirect()->route('publishers.archived')
            ->with('success', "{$publisher->name} has been restored.");
    }

    /**
     * Permanently delete an archived publisher.
     */
    public function forceDelete(int $id)
    {
        $publisher = Publisher::onlyTrashed()->findOrFail($id);
        $publisher->forceDelete();

        return redirect()->route('publishers.archived')
            ->with('success', 'Publisher permanently deleted.');
    }
}