<?php

namespace App\Http\Controllers;

use App\Models\EResource;
use Illuminate\Http\Request;

class CitationController extends Controller
{
    /**
     * Show citation formats for a specific e-resource.
     */
    public function show(EResource $eResource)
    {
        $eResource->load(['author', 'publisher', 'category']);

        $citations = $this->generateCitations($eResource);

        return view('citations.show', compact('eResource', 'citations'));
    }

    /**
     * Generate citations in APA, MLA, and Chicago formats.
     */
    private function generateCitations(EResource $eResource): array
    {
        $author    = $eResource->author;
        $publisher = $eResource->publisher;
        $year      = $eResource->publication_year ?? 'n.d.';
        $title     = $eResource->title;
        $pubName   = $publisher->name;
        $accessed  = now()->format('F j, Y');

        // Last, F. format
        $authorLastFirst = "{$author->last_name}, {$author->first_name}";
        // F. Last format
        $authorFirstLast = "{$author->first_name} {$author->last_name}";

        return [
            'apa' => "{$authorLastFirst} ({$year}). *{$title}*. {$pubName}.",

            'mla' => "{$authorLastFirst}. \"{$title}.\" {$pubName}, {$year}. Accessed {$accessed}.",

            'chicago' => "{$authorLastFirst}. \"{$title}.\" {$pubName}, {$year}.",
        ];
    }
}