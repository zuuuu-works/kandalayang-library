<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $history = AccessLog::with(['eResource.category', 'eResource.author'])
            ->where('user_id', Auth::id())
            ->latest('accessed_at')
            ->paginate(20);

        return view('history.index', compact('history'));
    }
}