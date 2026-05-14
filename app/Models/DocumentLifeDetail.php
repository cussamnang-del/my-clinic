<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentLifeDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the documentLife that owns the DocumentLifeDetail
     */
    public function documentLife(): BelongsTo
    {
        return $this->belongsTo(DocumentLife::class, 'document_lives_id', 'id');
    }
}
