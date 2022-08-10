<?php

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;



it('it test if a user can rename file', function(){
    $this->user = User::factory()->create();


    $token = $this->postJson('/api/login', [
        'email' => $this->user->email,
        'password' => "password"
    ]);
    $finalToken = $token->json();


    $file = File::factory()->create([
        "user_id" => $this->user->id
    ]);

    $id = $file->id;


    $fakedName ="cheatsheet";
    $response = $this->withHeaders(['Authorization' => "Bearer $finalToken"])->postJson("/api/rename/{$id}",[
        "name" => $fakedName
    ]);
    expect($response->json())->toBeArray();

   
});