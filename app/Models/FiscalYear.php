<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class FiscalYear extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'fiscal_year',
        'start_date',
        'end_date',
        'status',
        'is_active',
        'created_by',
        'updated_by',
        'note'
    ];

    protected static function booted(): void
    {
        static::saved(function (FiscalYear $fiscalYear) {
            Cache::forget('fiscal-years');
        });

        static::deleted(function (FiscalYear $fiscalYear) {
            Cache::forget('fiscal-years');
        });
    }
}
