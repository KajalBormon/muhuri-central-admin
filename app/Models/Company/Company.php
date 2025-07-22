<?php

namespace App\Models\Company;

use App\Models\CompanyCategory;
use App\Models\FailedJob;
use App\Models\Subscription\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_bn',
        'category_id',
        'email',
        'mobile_number',
        'additional_mobile_number',
        'domain',
        'workspace',
        'allowed_domains',
        'created_by',
        'updated_by',
        'is_active',
        'is_onboarding_completed',
        'otp',
        'otp_expire_at',
        'division_id',
        'district_id',
        'upazila_id',
        'union_id',
        'village'
    ];

    protected function casts(): array
    {
        return [
            'mobile_number_verified_at' => 'datetime'
        ];
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function companyCategory()
    {
        return $this->belongsTo(CompanyCategory::class, 'category_id');
    }

    public function companyOnboardingStep()
    {
        return $this->hasOne(CompanyOnboardingStep::class, 'company_id');
    }

    public function failedJobs()
    {
        return $this->hasMany(FailedJob::class, 'company_id');
    }
}
