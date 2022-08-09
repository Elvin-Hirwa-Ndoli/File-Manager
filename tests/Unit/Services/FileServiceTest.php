<?php

declare(strict_types = 1);

use App\DTOs\UploadFileRequestDTO;
use App\Models\File;
use App\Models\User;
use App\Services\FileService;

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
        'name' => $file->name,
        'user_id'=>$this->user->id
    ]);

});