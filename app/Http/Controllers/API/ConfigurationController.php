<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ConfigurationService;

class ConfigurationController extends Controller
{
    protected ConfigurationService $configurationService;

    public function __construct(ConfigurationService $configurationService)
    {
        $this->configurationService = $configurationService;
    }

    public function companyConfiguration(Request $request): JsonResponse
    {
        $configuration = $this->configurationService->getCompanyPublicConfiguration();
        return response()->json($configuration, Response::HTTP_OK);
    }
}
