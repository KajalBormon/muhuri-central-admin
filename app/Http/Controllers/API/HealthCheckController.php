<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class HealthCheckController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'API is working fine.'
        ]);
    }
}
