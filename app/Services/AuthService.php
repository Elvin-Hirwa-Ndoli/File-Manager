<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\CreateUserRequestDTO;
use App\DTOs\LoginRequestDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function registerUser(
        CreateUserRequestDTO $dto
    ): object {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => bcrypt($dto->password)
        ]);

        return $user;
    }

    public function Login(
        LoginRequestDTO $dto
    ): string {
        $user = User::where('email', $dto->email)->first();

        // Check password
        if (!$user || !Hash::check($dto->password, $user->password)) {
            return response([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return $token;
    }


    public function logout(): array
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}
