<?php

use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Validator;

it('can register user', function ($data) {

    $request = new CreateUserRequest($data);

    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeFalse();
})
    ->with([
        [
            [
                'name' => 'joy',
                'email' => 'joy2587543@gmail.com',
                'password' => 'joy@123',
                'password_confirmation' => 'joy@123'
            ]
        ]
    ]);



    it('can not register user', function ($data) {

        $request = new CreateUserRequest($data);
    
        $validator = Validator::make($data, $request->rules());
    
        expect($validator->fails())->toBeTrue();
    })
        ->with([
            [[]],
            [
                [
                    'name' => 'joy',
                    'email' => 'joy2587543@gmail.com',
                    'password' => 'joy@123',
                    'password_confirmation' => 'joy123'
                ]
            ]
        ]);
