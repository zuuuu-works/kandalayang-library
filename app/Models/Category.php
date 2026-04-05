<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * One Category has many E-Resources.
     */
    public function eResources(): HasMany
    {
        return $this->hasMany(EResource::class);
    }
}