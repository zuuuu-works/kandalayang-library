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

    // ─── Role Helpers ───────────────────────────────────────────────────────────

    public function isLibrarian(): bool
    {
        return $this->role === 'librarian';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isFaculty(): bool
    {
        return $this->role === 'faculty';
    }

    public function isResearcher(): bool
    {
        return $this->role === 'researcher';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // ─── Relationships ───────────────────────────────────────────────────────────

    /**
     * One User has many Access Logs.
     */
    public function accessLogs(): HasMany
    {
        return $this->hasMany(AccessLog::class);
    }
}