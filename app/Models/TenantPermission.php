<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantPermission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'guard_name',
        'group_name',
        'is_active'
    ];

    public function roles()
    {
        return $this->belongsToMany(TenantRole::class);
    }
}
