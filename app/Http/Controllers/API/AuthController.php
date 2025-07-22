<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login a user
     */
    public function adminLogin(LoginRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $token = $this->authService->adminLogin($validatedData);
        if($token){
            $responseData = [
                "success" => true,
                "message" => "Logged in successfully",
                "data" => [
                    'token' => $token,
                    'workspace' => $request->header('workspace')
                ]
            ];
            $httpStatus = 200;
        } else {
            $responseData = [
                "success" => false,
                "message" => "Credentials does not match",
                "data" => []
            ];
            $httpStatus = 401;
        }
        return response()->json($responseData, $httpStatus);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();
        $responseData = [
            "success" => true,
            "message" => "Logged out successfully",
            "data" => []
        ];
        return response()->json($responseData, Response::HTTP_OK);
    }
}
