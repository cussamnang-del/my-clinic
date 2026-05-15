<?php

namespace App\Models;

use App\Concerns\HasAuditColumns;
use App\Concerns\IsLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInformation extends Model
{
    use HasAuditColumns;
    use IsLoggable;
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_kh',
        'address',
        'phone1',
        'phone2',
        'phone3',
        'logo',
    ];
}
