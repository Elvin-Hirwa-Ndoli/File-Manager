<?php


use App\Models\File;
use App\Models\User;
use Illuminate\Http\Testing\File as TestingFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function(){
    $user = User::factory()->create();

    $this->actingAs($user);

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
