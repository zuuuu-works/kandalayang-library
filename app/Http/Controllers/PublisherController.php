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

    public function destroy(Publisher $publisher)
    {
        if ($publisher->eResources()->count() > 0) {
            return back()->with('error', 'Cannot delete — this publisher has existing e-resources.');
        }

        $publisher->delete();

        return redirect()->route('publishers.index')
            ->with('success', 'Publisher deleted successfully.');
    }
}