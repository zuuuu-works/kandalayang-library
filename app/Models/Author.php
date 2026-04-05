<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'bio',
    ];

    /**
     * Get the author's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * One Author has many E-Resources.
     */
    public function eResources(): HasMany
    {
        return $this->hasMany(EResource::class);
    }
}