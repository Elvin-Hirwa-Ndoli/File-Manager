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



    expect($response->json())->toBeString();
    $response->assertStatus(201);

});



it('it test if a user can logout and return true status code', function(){

    $token = $this->postJson('/api/login', [
        'email' => $this->user->email,
        'password' => "password"
    ]);
    $finalToken = $token->json();

    // dd($finalToken);

    $response = $this->withHeaders(['Authorization' => "Bearer $finalToken"])->postJson("/api/logout");

    expect($response->json())->toBeTrue();
    $response->assertStatus(201);

});

