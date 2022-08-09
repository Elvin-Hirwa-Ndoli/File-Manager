<?php

declare(strict_types=1);

use App\DTOs\LoginRequestDTO;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $this->service = new AuthService;

    $this->user = User::factory()->create();
});



it('test if can throw an Exception while passed data are not match', function ($email, $password) {

    $loginDTO = new LoginRequestDTO([
        "email" => $email,
        "password" => $password,
    ]);
    expect(fn () =>  $this->service->Login($loginDTO))->toThrow(Exception::class);
})->with([
    // [],
    [
        "elhirwa3@gmail.com", "password"
    ],

    [
        "elvinndoli@gmail.com", "pwd"
    ]
]);




it('test if can return token while passed data are match', function () {

    $loginDTO = new LoginRequestDTO([
        "email" => $this->user->email,
        "password" => 'password'
    ]);

    $response = $this->service->Login($loginDTO);

    expect($response)->toBeString();
    
});



it('test if can logout and Delete token', function(){

    $this->user->createToken('auth_token_kfkldjglkfdlkdfjdlkf');

    Auth::setUser($this->user);

    $response = $this->service->logout();

    expect($response)->toBeTrue()->and(Auth::user()->tokens()->count())->toBe(0);

});