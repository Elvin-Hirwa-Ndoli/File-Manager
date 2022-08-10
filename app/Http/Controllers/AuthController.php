<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\InvalidCredentialException;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(CreateUserRequest $request, AuthService $service)
    {

        $user = $service->registerUser($request->dto);

        return response()->json($user, 201);
    }

    public function login(LoginRequest $request, AuthService $service):JsonResponse
    {
        try{
            $token = $service->login($request->dto);

        }catch(InvalidCredentialException $exception){
            return response([
                'message' =>  $exception->getMessage()
            ], 401);
        }
        
        

        return response()->json($token, 201);
    }


    public function logout(AuthService $service):object 
    {
        $response = $service->logout();

        return response()->json($response);
    }
}



// try{
    //
// }
// dd(get_class($exception));
// catch{
    // return ...
// }
// catch{
    // return ....
// }
