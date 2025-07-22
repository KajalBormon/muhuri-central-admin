<?php

namespace App\Models\Subscription;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
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
        'updated_by',
        'is_active',
    ];
}
