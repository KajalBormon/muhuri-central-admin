<?php

namespace App\Services;

use Spatie\Activitylog\Models\Activity;

class ActivityLogService extends BaseModelService
{
    public function model(): string
    {
        return Activity::class;
    }

    public function getActivityLogs($user)
    {
        return $this->model()::where('causer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
