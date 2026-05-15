<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemGroup extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * Get all of the itemTypes for the ItemGroup
     */
    public function itemTypes(): HasMany
    {
        return $this->hasMany(ItemType::class, 'item_group_id', 'id');
    }
}
