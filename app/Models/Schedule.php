<?php

namespace App\Models;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [
      'ap_date',
      'created_at',
      'updated_at',
    ];

    public const APPOINTMENT_STATUS_RADIO = [
      '1'     => 'Pending',
      '2'     => 'Processing',
      '3'     => 'Complete',
    ];

    /**
     * Get the customer that owns the Schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
      return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function user(): BelongsTo
    {
      return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
      return $date->format('Y-m-d H:i:s');
    }
}
