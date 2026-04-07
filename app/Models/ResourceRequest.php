<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResourceRequest extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'author_name',
        'isbn',
        'publication_year',
        'purpose',
        'urgency',
        'status',
        'librarian_note',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}