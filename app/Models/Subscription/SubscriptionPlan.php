<?php

namespace App\Models\Subscription;

use App\Models\Subscription\SubscriptionPlanFeature;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'plan_type',
        'duration',
        'duration_unit',
        'trial_duration',
        'trial_duration_unit',
        'discount_amount',
        'note',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function subscriptionPlanFeatures()
    {
        return $this->belongsToMany(SubscriptionPlanFeature::class, 'subscription_plan_subscription_plan_feature');
    }
}
