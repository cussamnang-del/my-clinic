<?php

namespace App\Models;

use App\Models\User;
use App\Models\Customer;
use App\Models\Document;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the details for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details(): HasMany
    {
      return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    /**
     * Get the customer that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
      return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Get the document that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document(): BelongsTo
    {
      return $this->belongsTo(Document::class, 'document_id', 'id');
    }

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
      return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
