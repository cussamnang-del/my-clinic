<?php

namespace App\Models;

use App\Models\Hospital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the hospitals for the Room
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hospitals(): HasMany
    {
        return $this->hasMany(Hospital::class, 'room_id', 'id');
    }
}
