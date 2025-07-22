<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'logo',
        'slug',
        'base_url',
        'app_key',
        'app_secret',
        'username',
        'password',
        'is_active',
        'created_by',
        'updated_by'
    ];
}
