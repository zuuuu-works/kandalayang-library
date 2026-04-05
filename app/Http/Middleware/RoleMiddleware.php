<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage in routes: middleware('role:librarian')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Must be logged in
        if (! $user) {
            return redirect()->route('login');
        }

        // Must have an allowed role
        if (! in_array($user->role, $roles)) {
            abort(403, 'You do not have permission to access this page.');
        }

        // Must be active (Business Rule #9)
        if ($user->status === 'inactive') {
            abort(403, 'Your account is inactive. Please contact the librarian.');
        }

        return $next($request);
    }
}