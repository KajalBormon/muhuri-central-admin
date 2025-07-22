<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    protected $fillable = [
        'name',
        'name_bn',
        'slug',
        'is_active'
    ];
}
