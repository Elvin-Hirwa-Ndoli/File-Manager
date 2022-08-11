<?php

declare(strict_types=1);



use App\DTOs\UploadFileRequestDTO;

use App\DTOs\EditFileRequestDTO;
use App\DTOs\RenameFileRequestDTO;
use App\Models\File;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Testing\File as TestingFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


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

    expect($response)->toBeNull();

});



it("test if user can update the file ", function(){
    $file = File::factory()->create([
        "user_id"=>$this->user->id
    ]);

    Storage::fake('local');

    $File = UploadedFile::fake()->create('test.pdf', 100);

    $fileDTO = new EditFileRequestDTO(["file" => $File]);

   $response = $this->service->edit($file->id, $fileDTO);

   expect($response)->toBeNull();

});


it("test if can store file path and userID as expected", function(){
    $file = File::factory()->create([
        "user_id"=>$this->user->id
    ]);

    Storage::fake('local');

    $fakedFile = UploadedFile::fake()->create('quiz4.doc', 100);

    $fileDTO = new UploadFileRequestDTO(["file" => $fakedFile]);

    $this->service->upload($fileDTO,$this->user->id);



    $this->assertDatabaseHas('files', [
        'path' => $file->path,
        'name' => $file->name,
        'size' => $file->size,
        'extension' => $file->extension,        
        'user_id'=>$this->user->id
    ]);

});


it('test if can list all files in DataBase and return as Expected',   function () {

    File::factory()->create();

    $fileLIst = $this->service->list($this->user->id);

    // dd($fileLIst->toArray());


    expect($fileLIst)->toHaveKeys([
        "current_page",
        "data",
        "first_page_url",
        "from",
        "last_page",
        "last_page_url",
        "links",
        "next_page_url",
        "path",
        "per_page",
        "prev_page_url",
        "to",
        "total"
    ]);
});


it('test download method',function(){

    Storage::fake('local');
    
    $file = TestingFile::create('file.pdf',200);
    
    $path = $file->store('local');
    
    $dbFile= File::factory()->create([
        "name"=>$path
    ]);

     $res=$this->service->download($dbFile->id);
    
    expect($res)->toBe($path);

});


it('test delete  method', function(){

    Storage::fake('local');

    $file = TestingFile::create('photo.pdf',1000);

    $path = $file->store('local');

    $dbFile = File::factory()->create([
        'name' =>$path
    ]);
    
    $response = $this -> service->destroy($dbFile->id);

    expect($response)->toBeTrue();


    

 



})->only();

