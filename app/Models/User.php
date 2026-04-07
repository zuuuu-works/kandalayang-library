<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ─── Role Helpers ─────────────────────────────────────────────────────────

    public function isLibrarian(): bool  { return $this->role === 'librarian'; }
    public function isStudent(): bool    { return $this->role === 'student'; }
    public function isFaculty(): bool    { return $this->role === 'faculty'; }
    public function isResearcher(): bool { return $this->role === 'researcher'; }
    public function isActive(): bool     { return $this->status === 'active'; }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function accessLogs(): HasMany
    {
        return $this->hasMany(AccessLog::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Check if the user has bookmarked a specific resource.
     */
    public function hasBookmarked(int $eResourceId): bool
    {
        return $this->bookmarks()->where('e_resource_id', $eResourceId)->exists();
    }
}