<?php

use App\DTOs\CreateUserRequestDTO;
use Illuminate\Support\Facades\Hash;

it('can user be registed', function () {
    $faker = Faker\Factory::create();
    $name = $faker->name();
    $email = $faker->email();
    $password = Hash::make('password');

    $res=new CreateUserRequestDTO([
        'name' => $name,
        'email' => $email,
        'password' => $password
    ]);


    $response = $this->postJson('/api/register', [
        'name' => $res->name,
        'email' => $res->email,
        'password' => $res->password,
        'password_confirmation' => $password
    ]);

    $response->assertStatus(201);
})->only();
