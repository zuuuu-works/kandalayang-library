<?php

namespace App\Http\Controllers;

use App\Models\EResource;
use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileAccessController extends Controller
{
    /**
     * View or Download a file from storage.
     * Automatically logs the access (Business Rule #10)
     */
    public function access(Request $request, EResource $eResource)
    {
        $accessType = $request->get('type', 'view'); // 'view' or 'download'

        // Log the access
        AccessLog::create([
            'user_id'        => Auth::id(),
            'e_resource_id'  => $eResource->id,
            'accessed_at'    => now(),
            'access_type'    => $accessType,
        ]);

        // External URL — redirect directly
        if ($eResource->file_url && str_starts_with($eResource->file_url, 'http')) {
            return redirect()->away($eResource->file_url);
        }

        // Local storage file
        $path = $eResource->file_path;

        if (!$path || !Storage::disk('public')->exists($path)) {
            return back()->with('error', 'File not found. Please contact the librarian.');
        }

        $fullPath  = Storage::disk('public')->path($path);
        $fileName  = basename($path);
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Map extension to MIME type manually
        $mimeTypes = [
            'pdf'  => 'application/pdf',
            'epub' => 'application/epub+zip',
            'mp3'  => 'audio/mpeg',
            'mp4'  => 'video/mp4',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';

        if ($accessType === 'download') {
            return response()->download($fullPath, $fileName);
        }

        // View inline in browser
        return response()->file($fullPath, [
            'Content-Type'        => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }
}