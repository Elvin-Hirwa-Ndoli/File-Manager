<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    public function register(CreateUserRequest $request, AuthService $service)
    {

        $user = $service->registerUser($request->dto);

        return response()->json($user, 201);
    }




    public function login(LoginRequest $request, AuthService $service):object
    {
        try{
            $response = $service->Login($request->dto);

        }catch(ModelNotFoundException $exception){
            return response([
                'message' =>  $exception->getMessage()
            ], 401);
        }
        
        

        return response()->json($response, 201);
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
