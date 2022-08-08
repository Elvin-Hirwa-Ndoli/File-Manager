<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\UploadFileRequestDTO;
use App\Models\File;
use Illuminate\Support\Facades\Auth;

class FileService
{
    public function upload(
        UploadFileRequestDTO $dto,
        int $userID
        ):object
    {
        $file = File::create([
            'name' => $dto->name,
            'user_id' => $userID
        ]);

        return $file;
    }

    public function download($id){
        $file = File::where('id', $id)->firstOrFail();

        $path=storage_path().'/Docs/'.$file->name;
        
        return $path;
    
    }

    public function destroy($id){
        $file = File::where('id', $id)->firstOrFail();
        $path=storage_path().'/Docs/'.$file->name;
        
        return $path;
    
    }
}