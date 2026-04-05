<?php

namespace App\Http\Controllers;

use App\Models\EResource;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EResourceController extends Controller
{
    public function index()
    {
        $eResources = EResource::with(['category', 'author', 'publisher'])
            ->latest()
            ->paginate(10);

        return view('e-resources.index', compact('eResources'));
    }

    public function create()
    {
        $categories = Category::all();
        $authors    = Author::all();
        $publishers = Publisher::all();

        return view('e-resources.create', compact('categories', 'authors', 'publishers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'isbn'             => ['nullable', 'string', 'unique:e_resources'],
            'publication_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'file_type'        => ['nullable', 'string', 'max:50'],
            'category_id'      => ['required', 'exists:categories,id'],
            'author_id'        => ['required', 'exists:authors,id'],
            'publisher_id'     => ['required', 'exists:publishers,id'],
            'file_upload'      => ['nullable', 'file', 'mimes:pdf,epub,mp3,mp4,docx', 'max:51200'],
            'file_url'         => ['nullable', 'url'],
        ]);

        if ($request->hasFile('file_upload')) {
            $path = $request->file('file_upload')->store('e-resources', 'public');
            $validated['file_path'] = $path;
            $validated['file_url']  = null;
            $validated['file_type'] = strtoupper($request->file('file_upload')->getClientOriginalExtension());
        }

        unset($validated['file_upload']);

        EResource::create($validated);

        return redirect()->route('e-resources.index')
            ->with('success', 'E-Resource added successfully.');
    }

    public function show(EResource $eResource)
    {
        $eResource->load(['category', 'author', 'publisher', 'accessLogs']);
        return view('e-resources.show', compact('eResource'));
    }

    public function edit(EResource $eResource)
    {
        $categories = Category::all();
        $authors    = Author::all();
        $publishers = Publisher::all();

        return view('e-resources.edit', compact('eResource', 'categories', 'authors', 'publishers'));
    }

    public function update(Request $request, EResource $eResource)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'isbn'             => ['nullable', 'string', 'unique:e_resources,isbn,' . $eResource->id],
            'publication_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'file_type'        => ['nullable', 'string', 'max:50'],
            'category_id'      => ['required', 'exists:categories,id'],
            'author_id'        => ['required', 'exists:authors,id'],
            'publisher_id'     => ['required', 'exists:publishers,id'],
            'file_upload'      => ['nullable', 'file', 'mimes:pdf,epub,mp3,mp4,docx', 'max:51200'],
            'file_url'         => ['nullable', 'url'],
        ]);

        if ($request->hasFile('file_upload')) {
            if ($eResource->file_path) {
                Storage::disk('public')->delete($eResource->file_path);
            }
            $path = $request->file('file_upload')->store('e-resources', 'public');
            $validated['file_path'] = $path;
            $validated['file_url']  = null;
            $validated['file_type'] = strtoupper($request->file('file_upload')->getClientOriginalExtension());
        }

        unset($validated['file_upload']);

        $eResource->update($validated);

        return redirect()->route('e-resources.index')
            ->with('success', 'E-Resource updated successfully.');
    }

    public function destroy(EResource $eResource)
    {
        if ($eResource->file_path) {
            Storage::disk('public')->delete($eResource->file_path);
        }

        $eResource->delete();

        return redirect()->route('e-resources.index')
            ->with('success', 'E-Resource deleted successfully.');
    }
}