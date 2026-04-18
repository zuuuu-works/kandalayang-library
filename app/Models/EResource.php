<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class EResource extends Model
{
    use SoftDeletes;

    protected $table = 'e_resources';

    protected $fillable = [
        'title',
        'description',
        'isbn',
        'publication_year',
        'file_url',
        'file_path',
        'file_type',
        'category_id',
        'author_id',
        'publisher_id',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the public URL of the file (local or external).
     */
    public function getFileAccessUrlAttribute(): ?string
    {
        if ($this->file_path) {
            return Storage::disk('public')->url($this->file_path);
        }
        return $this->file_url;
    }

    public function hasFile(): bool
    {
        return !empty($this->file_path) || !empty($this->file_url);
    }

    public function category(): BelongsTo  { return $this->belongsTo(Category::class); }
    public function author(): BelongsTo    { return $this->belongsTo(Author::class)->withTrashed(); }
    public function publisher(): BelongsTo { return $this->belongsTo(Publisher::class)->withTrashed(); }
    public function accessLogs(): HasMany  { return $this->hasMany(AccessLog::class); }
    public function bookmarks(): HasMany   { return $this->hasMany(Bookmark::class); }
}