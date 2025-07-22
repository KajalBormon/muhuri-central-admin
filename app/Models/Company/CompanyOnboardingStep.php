<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyOnboardingStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'company_created',
        'database_created',
        'database_migrated',
        'initial_data_loaded',
        'tenant_permission_synced',
        'tenant_role_synced',
        'user_created',
        'subscription_synced',
        'item_synced',
        'brand_synced',
        'fiscal_year_synced',
        'free_sms_added',
        'payment_method_synced',
        'job_position_synced',
        'departure_reason_synced'
    ];

}
