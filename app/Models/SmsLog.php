<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'mobile_number',
        'request_body',
        'response_body',
        'sms_type',
        'message',
        'sms_count',
        'status'
    ];
}
