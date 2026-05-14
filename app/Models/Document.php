<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Znck\Eloquent\Traits\BelongsToThrough;

class Document extends Model
{
    use BelongsToThrough;
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = [
        'visit_date',
        'checkout_date',
    ];

    public function scopeHospital($query, $status)
    {
        return $query->where('checkout_status', '=', 'N')
            ->where('hospital_status', $status);
    }

    /**
     * Get the customer that owns the Document
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Get all of the documentLife for the Document
     */
    public function documentLives(): HasMany
    {
        return $this->hasMany(DocumentLife::class, 'document_id', 'id');
    }

    public function province()
    {
        return $this->belongsToThrough(
            Province::class,
            Customer::class
        )->withDefault(['name_en' => '']);
    }

    public function district()
    {
        return $this->belongsToThrough(
            District::class,
            Customer::class
        )->withDefault(['name_en' => '']);
    }

    public function commune()
    {
        return $this->belongsToThrough(
            Commune::class,
            Customer::class
        )->withDefault(['name_en' => '']);
    }

    public function village()
    {
        return $this->belongsToThrough(
            Village::class,
            Customer::class
        )->withDefault(['name_en' => '']);
    }

    /**
     * Get all of the details for the Document
     */
    public function details(): HasMany
    {
        return $this->hasMany(DocumentDetail::class, 'document_id', 'id');
    }

    public function getAddressAttribute()
    {
        $address = '';
        if ($this->province->name_en != '') {
            $address = $this->province->name_en;
        }
        if ($this->district->name_en != '') {
            $address = $this->province->name_en.', '.$this->district->name_en;
        }
        if ($this->commune->name_en != '') {
            $address = $this->province->name_en.', '.$this->district->name_en.', '.$this->commune->name_en;
        }
        if ($this->village->name_en != '') {
            $address = $this->province->name_en.', '.$this->district->name_en.', '.$this->commune->name_en.', '.$this->village->name_en;
        }

        return $address;
    }

    // protected function serializeDate(\DateTimeInterface $date)
    // {
    //   return $date->format('d-m-Y H:i:s');
    // }
}
