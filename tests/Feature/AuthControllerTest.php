<?php

declare(strict_types = 1);

use App\Models\User;

beforeEach(function () {

    $this->user = User::factory()->create();
});



it('it test if a user can login and return token', function(){

    $response = $this->postJson('/api/login', [
        'email' => $this->user->email,
        'password' => "password"
    ]);

    // dd($response->json());

    expect($response->json())->toBeString();
    $response->assertStatus(201);

});

// it('test if can throw an Exception if if credentials are invalid', function($email,$password){

//     $response = $this->postJson('/api/login', [
//         'email' => $email,
//         'password' => $password
//     ]);

//     expect($response->json())->toBeString();
//     $response->assertStatus(401);

// })->with(
//     [
//         [
//             "elvinhirwa@gmail.com",
//             "danger"
//         ],
//         [
//             "elhirwa32@gmail.com",
//             "123458"
//         ]


//     ]
// );
