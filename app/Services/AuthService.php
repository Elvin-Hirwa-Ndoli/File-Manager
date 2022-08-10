<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\CreateUserRequestDTO;
use App\DTOs\LoginRequestDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function registerUser(
        CreateUserRequestDTO $dto

    ): User {

        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password)
        ]);

        return $user;
    }

    /**
     * @throws Exception
     */
    public function login(
        LoginRequestDTO $dto
    ): string {
        $user = User::where('email', $dto->email)->first();

        // Check password
        if ( is_null($user) || !Hash::check($dto->password, $user->password)) {
            
            throw new ModelNotFoundException("Invalid credentials");
            
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        
        return $token;
    }


    public function logout(): bool
    {
        auth()->user()->tokens()->delete();

        return true;
    }
}
