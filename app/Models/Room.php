<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the hospitals for the Room
     */
    public function hospitals(): HasMany
    {
        return $this->hasMany(Hospital::class, 'room_id', 'id');
    }
}
