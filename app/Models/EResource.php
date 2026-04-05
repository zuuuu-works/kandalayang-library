<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EResource extends Model
{
    protected $table = 'e_resources';

    protected $fillable = [
        'title',
        'description',
        'isbn',
        'publication_year',
        'file_url',
        'file_type',
        'category_id',
        'author_id',
        'publisher_id',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────────

    /**
     * Each E-Resource belongs to one Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Each E-Resource belongs to one Author.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Each E-Resource belongs to one Publisher.
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    /**
     * One E-Resource has many Access Logs.
     */
    public function accessLogs(): HasMany
    {
        return $this->hasMany(AccessLog::class);
    }
}