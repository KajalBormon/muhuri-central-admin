<?php

namespace App\Services\SMS;

use App\Services\ConfigurationService;
use Illuminate\Support\Facades\Http;

class SmsGatewayService
{

    private ConfigurationService $configurationService;
    private SmsLogService $smsLogService;

    public function __construct(ConfigurationService $configurationService, SmsLogService $smsLogService)
    {
        $this->configurationService = $configurationService;
        $this->smsLogService = $smsLogService;
    }

    public function sendSMS($number, $message)
    {
        $apiKey = $this->configurationService->getConfiguration('sms_service_api_key');
        $senderId = $this->configurationService->getConfiguration('sms_service_sender_id');
        $baseUrl = $this->configurationService->getConfiguration('sms_service_base_url');
        $data = [
            "api_key" => $apiKey,
            "senderid" => $senderId,
            "number" => $number,
            "message" => $message
        ];

        $response = Http::post($baseUrl, $data);
        $smsCount = 1;
        $status = $response->successful() ? 'sent' : 'failed';
        $this->smsLogService->createSmsLog([
            'mobile_number' => $number,
            'request_body' => $message,
            'response_body' => $response->body(),
            'sms_type' => 'OTP',
            'message' => $message,
            'sms_count' => $smsCount,
            'status' => $status
        ]);
        return $response->body();
    }
}
