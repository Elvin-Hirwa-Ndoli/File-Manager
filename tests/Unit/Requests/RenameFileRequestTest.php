<?php

use App\Http\Requests\RenameFileRequest;
use Illuminate\Support\Facades\Validator;

it('test if it can fail if validated fields in rename files are not valid', function (array $data) {

    $request = new RenameFileRequest($data);

    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
})
    ->with([
        [[]],

    ]);


    it('test if it can pass if validated field is valid', function (array $data) {

        $request = new RenameFileRequest($data);
    
        $validator = Validator::make($data, $request->rules());
    
        expect($validator->fails())->toBeFalse();
    })
        ->with([
            [[
              'name'=>'cheatcheet'
            ]],
        ]);
