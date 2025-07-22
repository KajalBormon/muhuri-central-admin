<?php

namespace App\Models\Subscription;

use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_plan_id',
        'company_id',
        'start_date',
        'end_date',
        'price',
        'discount_amount',
        'final_price',
        'is_trial_taken',
        'trial_start_date',
        'trial_end_date',
        'note',
        'is_active',
    ];

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
