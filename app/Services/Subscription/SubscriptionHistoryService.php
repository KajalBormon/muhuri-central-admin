<?php
namespace App\Services\Subscription;

use App\Models\Subscription\SubscriptionHistory;
use App\Services\BaseModelService;

class SubscriptionHistoryService extends BaseModelService
{
    public function model(): string
    {
        return SubscriptionHistory::class;
    }
}