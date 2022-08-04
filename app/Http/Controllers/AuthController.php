<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function register(CreateUserRequest $request, AuthService $service)
    {

        $user = $service->registerUser($request->dto);

        return response()->json($user, 201);
    }




    public function login(LoginRequest $request, AuthService $service):object
    {
        $response = $service->Login($request->dto);

        return response()->json($response, 201);
    }




    public function logout(AuthService $service):object 
    {
        $response = $service->logout();

        return response()->json($response);
    }
}
