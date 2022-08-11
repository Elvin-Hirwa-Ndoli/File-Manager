<?php


use App\DTOs\CreateUserRequestDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


beforeEach(function () {

    $this->user = User::factory()->create();
});




it('test if a user can login and return token', function(){

    $response = $this->postJson('/api/login', [
        'email' => $this->user->email,
        'password' => "password"
    ]);


    expect($response->json())->toBeString();
    $response->assertStatus(201);

});



it('test if a user can logout and return true status code', function(){

    $token = $this->postJson('/api/login', [
        'email' => $this->user->email,
        'password' => "password"
    ]);
    $finalToken = $token->json();

    $response = $this->withHeaders(['Authorization' => "Bearer $finalToken"])->postJson("/api/logout");

    expect($response->json())->toBeTrue();
    $response->assertStatus(201);

});

