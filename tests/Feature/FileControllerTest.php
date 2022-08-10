<?php


use App\Models\File;
use App\Models\User;
use Illuminate\Http\Testing\File as TestingFile;
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


it('can download file', function(){


    $file = TestingFile::create('google.pdf',300);

    $path=$file->store('Docs/');


    $dbfile = File::factory()->create([
        'name'=>$path
    ]);
    $response = $this->getJson("/api/download/{$dbfile->id}");

    $response->assertSuccessful();

    Storage::shouldReceive('download')
    ->with($path)
    ->andReturn($file);

});


it('ican delete file?', function(){


    $file = TestingFile::create('google.pdf',300);

    $path=$file->store('Docs/');


    $dbfile = File::factory()->create([
        'name'=>$path
    ]);
    $response = $this->delete("/api/delete/{$dbfile->id}");
  

    $response->assertStatus(200);
   
});
