<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Display all users. (Librarian only)
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Show a specific user's details. (Librarian only)
     */
    public function show(User $user)
    {
        $user->load('accessLogs.eResource');

        return view('users.show', compact('user'));
    }

    /**
     * Show the form to edit a user. (Librarian only)
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update a user's role or status. (Librarian only)
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email,' . $user->id],
            'role'       => ['required', 'in:librarian,student,faculty,researcher'],
            'status'     => ['required', 'in:active,inactive'],
        ]);

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Deactivate a user account. (Librarian only)
     */
    public function deactivate(User $user)
    {
        $user->update(['status' => 'inactive']);

        return redirect()->route('users.index')
            ->with('success', "{$user->full_name} has been deactivated.");
    }

    /**
     * Activate a user account. (Librarian only)
     */
    public function activate(User $user)
    {
        $user->update(['status' => 'active']);

        return redirect()->route('users.index')
            ->with('success', "{$user->full_name} has been activated.");
    }
}