<?php

namespace App\Http\Controllers;

use App\Services\LanguageService;

class LanguageController extends Controller
{
    protected LanguageService $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function getLanguageOptions()
    {
        $languageOptions = $this->languageService->getLanguageOptions();
        $response = [
            'success' => true,
            'message' => 'Get language options',
            'data' => [
                'languageOptions' => $languageOptions
            ]
        ];
        $httpStatus = 200;
        return response()->json($response, $httpStatus);
    }
}
