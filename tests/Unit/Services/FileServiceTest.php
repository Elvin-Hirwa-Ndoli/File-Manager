<?php

// declare(strict_types = 1);


use App\DTOs\UploadFileRequestDTO;
use App\Models\File as ModelsFile;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Testing\File as TestingFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;





it('test download method',function(){

    Storage::fake('local');
    
    $file = TestingFile::create('file.pdf',200);
    
    $path = $file->store('local');
    
    $dbFile= ModelsFile::factory()->create([
        "name"=>$path
    ]);

     $res=$this->service->download($dbFile->id);
    
    expect($res)->toBe($path);

});


it('test delete  method', function(){

    Storage::fake('local');

    $file = TestingFile::create('photo.pdf',1000);

    $path = $file->store('local');

    $dbFile = ModelsFile::factory()->create([
        'name' =>$path
    ]);
    
    $response = $this -> service->destroy($dbFile->id);

    expect($response)->toBeArray;



})->only();

