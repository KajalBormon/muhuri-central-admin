<?php

namespace App\Services\SMS;


use App\Models\SmsLog;
use App\Services\BaseModelService;

class SmsLogService extends BaseModelService
{
    public function model(): string
    {
        return SmsLog::class;
    }


    public function createSmsLog($data): SmsLog
    {
        return $this->create($data);
    }
}
