<?php

declare(strict_types=1);

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


it("test if the  user can rename file", function () {
    $file = File::factory()->create([
        "user_id" => $this->user->id
    ]);

    $name = 'cheatsheet';

    $fileDTO = new RenameFileRequestDTO(["name" => $name]);


    $response = $this->service->Rename($file->id, $fileDTO);

    expect($response)
        ->toBeArray()
        ->toHaveKey(0);
        $this->assertDatabaseHas('files', ["name"=>'cheatsheet']);
});



it("test if user can update the file ", function(){
    $file = File::factory()->create([
        "user_id"=>$this->user->id
    ]);

    Storage::fake('local');

    $File = UploadedFile::fake()->create('test.pdf', 100);

    $fileDTO = new EditFileRequestDTO(["file" => $File]);

   $response = $this->service->edit($file->id, $fileDTO);

   expect($response)->toBeTrue();

})->only();



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



});


