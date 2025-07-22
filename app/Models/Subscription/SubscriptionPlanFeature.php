<?php

namespace App\Models\Subscription;

use App\Models\Subscription\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'created_by',
        'updated_by',
        'is_active',
    ];

    public function subscriptionPlans()
    {
        return $this->belongsToMany(SubscriptionPlan::class, 'subscription_plan_subscription_plan_feature');
    }
}
