<?php

use App\DTOs\CreateUserRequestDTO;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->service = new AuthService;
});


it('test if can do register user', function(){
    

    $faker = Faker\Factory::create();
    $name = $faker->name();
    $email = $faker->email();
    $password = Hash::make('password');
    $userDTO = new CreateUserRequestDTO([ 
        'name' => $name,
            'email' => $email,
            'password' =>$password
     ]);

    $response = $this->service->registerUser($userDTO);
    
    expect($response)->toBeInstanceOf(User::class);

    $this->assertDatabaseHas((new User())->getTable(), [
        "name" => $name,
        "email" => $email
    ]);
    
})->only();



