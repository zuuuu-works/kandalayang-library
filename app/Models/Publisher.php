<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publisher extends Model
{
    protected $fillable = [
        'name',
        'email',
        'website',
        'address',
    ];

    /**
     * One Publisher has many E-Resources.
     */
    public function eResources(): HasMany
    {
        return $this->hasMany(EResource::class);
    }
}