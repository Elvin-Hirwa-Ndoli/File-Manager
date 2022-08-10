<?php

declare(strict_types = 1);


use App\Http\Requests\UploadFileRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

it('test if it can fail if validated fields in Upload File request are not Match', function (array $data) {

    $request = new UploadFileRequest($data);

    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
})
    ->with([
        [[]],
        [
            function () {
                Storage::fake('local');
                $file = UploadedFile::fake()->create('quiz4.jpeg', 100);

                $data = [
                    
                    'file' => $file
                ];
                return $data;
            }
        ],
        [
            function () {
                Storage::fake('local');
                $file = UploadedFile::fake()->create('quiz4.pdf', 100000000);

                $data = [
                    
                    'file' => $file
                ];
                return $data;
            }
        ]
    ]);



    it('test if it can pass if validated fields in Upload File request are Match', function (array $data) {

        $request = new UploadFileRequest($data);
    
        $validator = Validator::make($data, $request->rules());
    
        expect($validator->fails())->toBeFalse();
    })
        ->with([
            [
                function () {
                    Storage::fake('local');
                    $file = UploadedFile::fake()->create('quiz4.doc', 100);
    
                    $data = [
                        
                        'file' => $file
                    ];
                    return $data;
                }
            ],
        ]);