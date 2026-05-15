<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use App\Services\ResultReleaseService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class BioDetail extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $fillable = [
        'bio_id',
        'customer_id',
        'document_id',
        'item_group_id',
        'item_type_id',
        'date',
        'result',
        'note',
        'result_status',
        'result_flag',
        'amendment_reason',
        'amends_id',
        'submitted_by',
        'submitted_at',
        'reviewed_by',
        'reviewed_at',
        'released_by',
        'released_at',
        'amended_by',
        'amended_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'released_at' => 'datetime',
        'amended_at' => 'datetime',
    ];

    public function isDraft(): bool
    {
        return $this->result_status === ResultReleaseService::STATE_DRAFT;
    }

    public function isReleased(): bool
    {
        return $this->result_status === ResultReleaseService::STATE_RELEASED;
    }

    public function amends(): BelongsTo
    {
        return $this->belongsTo(self::class, 'amends_id');
    }

    /**
     * Get the itemGroup that owns the BioDetail
     */
    public function itemGroup(): BelongsTo
    {
        return $this->belongsTo(ItemGroup::class);
    }

    /**
     * Get the itemType that owns the BioDetail
     */
    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class);
    }

    /**
     * Get the item that owns the BioDetail
     *
     * @return BelongsTo
     */
    // public function item(): BelongsTo
    // {
    //   return $this->belongsTo(Item::class, 'item_id', 'id');
    // }

    /**
     * Get all of the comments for the BioDetail
     *
     * @return HasOneThrough
     */
    public function customer()
    {
        return $this->hasOneThrough(
            Customer::class,
            Bio::class,
            'id', // Foreign key on orders table...
            'id',
            'bio_id',
            'customer_id', // Foreign key on products table...
        );
    }

    /**
     * Get all of the comments for the BioDetail
     *
     * @return HasOneThrough
     */
    public function item()
    {
        return $this->hasOneThrough(
            Item::class,
            Bio::class,
            'id', // Foreign key on orders table...
            'id',
            'bio_id',
            'item_id', // Foreign key on products table...
        );
    }

    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Bio::class,
            'id', // Foreign key on orders table...
            'id',
            'bio_id',
            'user_id', // Foreign key on products table...
        );
    }

    /**
     * Get the bio that owns the BioDetail
     */
    public function bio(): BelongsTo
    {
        return $this->belongsTo(Bio::class, 'bio_id', 'id');
    }
}
