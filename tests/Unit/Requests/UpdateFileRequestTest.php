<?php

use App\Http\Requests\RenameFileRequest;
use App\Http\Requests\UploadFileRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

it('test if it can fail if validated fields in update files are not valid', function (array $data) {

    $request = new UploadFileRequest($data);

    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
})
    ->with([
        [[]],

    ]);


    it('test if it can Pass if validated fields in  request are valid', function ($data) {

        $request = new UploadFileRequest($data);
    
        $validator = Validator::make($data, $request->rules());
    
        expect($validator->fails())->toBeFalse();
    })
        ->with([
            [
                    function () {
                        Storage::fake('local');
                        $file = UploadedFile::fake()->create('test.pdf', 100000);
    
                        $data = [
                            'id' => 1,
                            'file' => $file,
                           
                        ];
                        return $data;
                    }
                
            ]
    
                ]);
    