<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService extends BaseModelService
{
    public function model(): string
    {
        return User::class;
    }

    public function adminLogin($validatedData)
    {
        if(Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            $user = Auth::user();
            $token =  $user->createToken('admin-auth-token')->plainTextToken;
            return $token;
        } else {
            return false;
        }
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return true;
    }
}
