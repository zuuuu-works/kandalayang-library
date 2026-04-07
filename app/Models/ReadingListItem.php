<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadingListItem extends Model
{
    protected $fillable = [
        'reading_list_id',
        'e_resource_id',
        'order',
    ];

    public function readingList(): BelongsTo
    {
        return $this->belongsTo(ReadingList::class);
    }

    public function eResource(): BelongsTo
    {
        return $this->belongsTo(EResource::class);
    }
}