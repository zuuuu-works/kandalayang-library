<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessLog extends Model
{
    protected $table = 'access_logs';

    protected $fillable = [
        'user_id',
        'e_resource_id',
        'accessed_at',
        'access_type',
    ];

    protected $casts = [
        'accessed_at' => 'datetime',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────────

    /**
     * Each Access Log belongs to one User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Each Access Log belongs to one E-Resource.
     */
    public function eResource(): BelongsTo
    {
        return $this->belongsTo(EResource::class);
    }
}