<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publisher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'website',
        'address',
    ];

    protected $dates = ['deleted_at'];

    public function eResources(): HasMany
    {
        return $this->hasMany(EResource::class);
    }
}