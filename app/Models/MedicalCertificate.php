<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalCertificate extends Model
{
    use HasAuditColumns;
    use HasFactory;
    use IsLoggable;
    use SoftDeletes;

    protected $fillable = [
        'date',
        'time',
        'document_id',
        'customer_id',
        'chief_complain',
        'past_history',
        'examination',
        'diagnosis',
        'treatment',
        'is_sick',
        'from_date',
        'to_date',
        'attending',
        'is_other',
        'note',
        'user_id',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'date',
        'from_date',
        'to_date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Get the document that owns the OperativeProtocol
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id', 'id');
    }

    // protected function serializeDate(DateTimeInterface $date)
    // {
    //   return $date->format('d-m-Y');
    // }
}
