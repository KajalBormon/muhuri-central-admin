<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantRole extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'guard_name',
        'is_editable',
        'is_deletable',
        'is_available',
        'is_active'
    ];

    public function permissions()
    {
        return $this->belongsToMany(TenantPermission::class);
    }
}
