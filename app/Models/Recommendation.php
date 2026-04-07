<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recommendation extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'author_name',
        'publisher_name',
        'publication_year',
        'file_type',
        'reason',
        'resource_url',
        'status',
        'librarian_note',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}