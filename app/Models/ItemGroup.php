<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemGroup extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the itemTypes for the ItemGroup
     */
    public function itemTypes(): HasMany
    {
        return $this->hasMany(ItemType::class, 'item_group_id', 'id');
    }
}
