<?php

namespace App\Models;

use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hospital extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the room that owns the Hospital
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room(): BelongsTo
    {
      return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    // protected function serializeDate(\DateTimeInterface $date)
    // {
    //   return $date->format('Y-m-d H:i:s');
    // }
}
