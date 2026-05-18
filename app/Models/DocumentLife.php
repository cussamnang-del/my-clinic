<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentLife extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $fillable = [
        'document_id',
        'coltype',
        'colfield',
        'coldesr',
        'col_measure',
        'coltime',
        'num',
        'status',
    ];

    /**
     * Get the document that owns the DocumentLife
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id', 'id');
    }

    /**
     * Get all of the doclifedetail for the DocumentLife
     */
    public function doclifedetails(): HasMany
    {
        return $this->hasMany(DocumentLifeDetail::class, 'document_lives_id', 'id');
    }

    /**
     * Get the lifesign that owns the DocumentLife
     */
    public function lifesign(): BelongsTo
    {
        return $this->belongsTo(LifeSign::class, 'colfield', 'id');
    }

    /**
     * Get the colType that owns the DocumentLife
     */
    public function colType(): BelongsTo
    {
        return $this->belongsTo(LifeSign::class, 'coltype', 'id');
    }

    /**
     * Get the customer that owns the DocumentLife
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Get all of the colFields for the DocumentLife
     */
    public function colFields(): HasMany
    {
        return $this->hasMany(DocumentLifeDetail::class, 'colfield', 'colfield')->orderBy('coldate', 'desc');
    }
}
