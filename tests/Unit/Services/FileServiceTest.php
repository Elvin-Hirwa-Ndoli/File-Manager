<?php

declare(strict_types = 1);

use App\DTOs\UploadFileRequestDTO;
use App\Models\File as ModelsFile;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Testing\File as TestingFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

beforeEach(function () {

    $this->user = User::factory()->create();

    $this->service = new FileService;
});


it("test if can store file path and userID as expected", function(){
    $file = File::factory()->create([
        "user_id"=>$this->user->id
    ]);

    $fileDTO = new UploadFileRequestDTO(["name" => $file->name]);

    $response = $this->service->upload($fileDTO,$this->user->id);

    expect($response)->toBeObject();
    expect($this->user->id)->toBeInt();
    expect($fileDTO)->toBeObject();
    $this->assertDatabaseHas('files', [
        'name' => $file->name
    ]);

});

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