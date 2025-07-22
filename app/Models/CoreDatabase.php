<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreDatabase extends Model
{
    use HasFactory;

    protected $fillable = [
        'db_type',
        'db_host',
        'db_username',
        'db_password',
        'db_name',
        'db_port',
        'is_active'
    ];
}
