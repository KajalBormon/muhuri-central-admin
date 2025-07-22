<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantPermissionTenantRole extends Model
{
    protected $fillable = [
        'tenant_role_id',
        'tenant_permission_id'
    ];
}
