<?php

declare(strict_types=1);

use App\DTOs\EditFileRequestDTO;
use App\DTOs\RenameFileRequestDTO;
use App\Models\File;
use App\Models\User;
use App\Services\FileService;
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





