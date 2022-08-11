<?php

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;



it('it test if a user can update file', function(){
    $this->user = User::factory()->create();


    $token = $this->postJson('/api/login', [
        'email' => $this->user->email,
        'password' => "password"
    ]);
    $finalToken = $token->json();

    $fakedStorage = Storage::fake('local');

    $file = File::factory()->create([
        "user_id" => $this->user->id
    ]);

    $fakeFile = UploadedFile::fake()->create('test.pdf', 1000);

     $id = $file->id;


    $response = $this->withHeaders(['Authorization' => "Bearer $finalToken"])->postJson("/api/edit/{$id}",[
        "file"=>$fakeFile
    ]);
    expect($response->json())->toBeTrue();
    $fakedStorage->assertMissing($fakeFile);

   
});