<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasAuditColumns;
    use IsLoggable;
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'p_name',
        'p_code',
        'p_price',
        'group_id',
        'type_id',
        'description',
        'country',
        'image',
        'status',
    ];
}
