<?php

declare(strict_types = 1);

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;

it('test if it can fail if validated fields in Login request are not Match', function (array $data) {

    $request = new LoginRequest($data);

    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
})
    ->with([
        [[]],
        [
            [
                'email' => 3,
                'password' => "123"
            ]
        ],
        [
            [
                'email' => "elhirwa3gmail.com",
                'password' => "123"
            ]
        ],
        [
            [
                'email' => "elhirwa3@gmail.com",
                'password' => 123
            ]
        ],
    ]);


it('test if it can pass if validated fields in Login request are Match', function (array $data) {

    $request = new LoginRequest($data);

    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeFalse();
})
    ->with([
        [[
            'email' => "elhirwa3@gmail.com",
            'password' => "123"
        ]],
    ]);


   