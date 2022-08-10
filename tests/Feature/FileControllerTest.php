<?php

declare(strict_types = 1);

use App\Models\File;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {

    $this->user = User::factory()->create();
});




it('it test if a user can upload file and return true status code', function(){

    $token = $this->postJson('/api/login', [
        'email' => $this->user->email,
        'password' => "password"
    ]);
    $finalToken = $token->json();

    Storage::fake('local');

    $fakedFile = UploadedFile::fake()->create('quiz4.doc', 100);

    $upload = $this->withHeaders(['Authorization' => "Bearer $finalToken"])->postJson("/api/upload",[
        "file"=>$fakedFile
    ]);

    expect($upload->json())->toBeArray();
    $upload->assertStatus(200);

});





it('it test if a user can list all files he/she has created and true status code', function(){

    $token = $this->postJson('/api/login', [
        'email' => $this->user->email,
        'password' => "password"
    ]);
    $finalToken = $token->json();

    $listFiles = $this->withHeaders(['Authorization' => "Bearer $finalToken"])->getJson("/api/list");

    expect($listFiles->json())->toBeArray();
    $listFiles->assertStatus(200);

});


