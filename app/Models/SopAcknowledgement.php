<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SopAcknowledgement extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'acknowledged_at' => 'datetime',
    ];

    public function sopRevision(): BelongsTo
    {
        return $this->belongsTo(SopRevision::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
