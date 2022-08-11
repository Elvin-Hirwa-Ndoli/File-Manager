<?php


use App\Models\File;
use App\Models\User;
use Illuminate\Http\Testing\File as TestingFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {

    $this->user = User::factory()->create();

    Storage::fake('local');

    $this->fakedFile = UploadedFile::fake()->create('quiz4.doc', 100);
});




it('it test if a user can upload file and return true status code', function(){

    $token = $this->postJson('/api/login', [
        'email' => $this->user->email,
        'password' => "password"
    ]);
    $finalToken = $token->json();

    

    $upload = $this->withHeaders(['Authorization' => "Bearer $finalToken"])->postJson("/api/upload",[
        "file"=>$this->fakedFile
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


    expect($response->json())->toBeArray();
    $fakedStorage->assertMissing($fakeFile);

   
});



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


it ('it can download',function(){

    $user = User::factory()->create();
    $this->actingAs($user);

    
    $file = TestingFile::create('file.pdf',200);
    
    $path = $file->store('local');
    
    $dbFile= File::factory()->create([
        "name"=>$path
    ]);

     $response= $this->getJson("/api/download/{$dbFile->id}");

     $response -> assertSuccessful();
    

});


it ('it can delete',function(){

    $user = User::factory()->create();
    $this->actingAs($user);

    
    $file = TestingFile::create('file.pdf',200);
    
    $path = $file->store('local');
    
    $dbFile= File::factory()->create([
        "name"=>$path
    ]);

     $response= $this->delete("/api/delete/{$dbFile->id}");

    $this-> assertDatabaseMissing('files',['name' => 'file.pdf']);

     $response -> assertSuccessful();
    
});
